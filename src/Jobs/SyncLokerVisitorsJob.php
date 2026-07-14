<?php

namespace Bale\Loker\Jobs;

use Bale\Cms\Models\BaleList;
use Bale\Cms\Services\AnalyticsService;
use Bale\Cms\Services\TenantConnectionService;
use Bale\Cms\Services\TenantManager;
use Bale\Loker\Models\Loker;
use Bale\Loker\Models\LokerVisitor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SyncLokerVisitorsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;

    public int $tries = 3;

    public function __construct(
        public string $baleUuid,
        public int $days = 30,
    ) {}

    public function handle(): void
    {
        $tenant = BaleList::where('id', $this->baleUuid)->firstOrFail();

        TenantManager::initializeFromBaleUuid($tenant->id);

        session(['bale_active_uuid' => $tenant->id]);
        session(['bale_active_slug' => $tenant->slug]);

        $lokers = Loker::all();

        if ($lokers->isEmpty()) {
            return;
        }

        $analyticsService = new AnalyticsService;
        $timezone = config('core.analytics.umami.timezone', 'Asia/Jakarta');

        $chunks = [];
        $remainingDays = $this->days;
        $currentOffset = 0;

        while ($remainingDays > 0) {
            $daysInChunk = min(30, $remainingDays);
            $chunkEnd = now($timezone)->subDays($currentOffset)->endOfDay();
            $chunkStart = now($timezone)->subDays($currentOffset + $daysInChunk - 1)->startOfDay();

            $chunks[] = [
                'days_count' => $daysInChunk,
                'range' => [$chunkStart->getTimestampMs(), $chunkEnd->getTimestampMs()],
                'chunk_start' => $chunkStart,
            ];

            $remainingDays -= $daysInChunk;
            $currentOffset += $daysInChunk;
        }

        $connection = TenantConnectionService::connection();

        foreach ($chunks as $chunk) {
            $daysRange = $chunk['range'];
            $chunkStart = $chunk['chunk_start'];

            foreach ($lokers as $loker) {
                $path = "/jobs/{$loker->slug}";

                try {
                    $pathStats = $analyticsService->getPathStats($path, $daysRange);

                    if (empty($pathStats['unavailable'])) {
                        $chartData = $pathStats['chart'];

                        $overview = $pathStats['overview'];
                        $bounceRateStr = data_get($overview, 'bounce_rate', 'N/A');
                        $bounceRate = $bounceRateStr !== 'N/A' ? (float) str_replace('%', '', $bounceRateStr) : null;

                        $avgDurationStr = data_get($overview, 'avg_session_duration', 'N/A');
                        $avgSeconds = null;
                        if ($avgDurationStr !== 'N/A') {
                            if (preg_match('/(?:(\d+)m)?\s*(?:(\d+)s)?/', $avgDurationStr, $matches)) {
                                $minutes = isset($matches[1]) ? (int) $matches[1] : 0;
                                $seconds = isset($matches[2]) ? (int) $matches[2] : 0;
                                $avgSeconds = ($minutes * 60) + $seconds;
                            }
                        }

                        foreach ($chartData['page_views'] as $index => $pageviewsCount) {
                            $day = $chunkStart->copy()->addDays($index);
                            $dateString = $day->format('Y-m-d');

                            $visitorsCount = isset($chartData['visitors'][$index])
                                ? (int) $chartData['visitors'][$index]
                                : 0;

                            if ($pageviewsCount > 0 || $visitorsCount > 0) {
                                LokerVisitor::updateOrCreate(
                                    [
                                        'loker_slug' => $loker->slug,
                                        'date' => $dateString,
                                    ],
                                    [
                                        'pageviews' => $pageviewsCount,
                                        'visitors' => $visitorsCount,
                                        'bounce_rate' => $bounceRate,
                                        'avg_session_duration' => $avgSeconds,
                                    ]
                                );
                            }
                        }
                    }
                } catch (Throwable $e) {
                    continue;
                }
            }
        }
    }

    public function failed(?Throwable $exception): void
    {
        \Log::error("SyncLokerVisitorsJob failed for tenant {$this->baleUuid}: ".$exception?->getMessage());
    }
}
