<?php

namespace Bale\Loker\Commands;

use Bale\Cms\Models\BaleList;
use Bale\Cms\Services\AnalyticsService;
use Bale\Cms\Services\TenantConnectionService;
use Bale\Cms\Services\TenantManager;
use Bale\Loker\Models\Loker;
use Bale\Loker\Models\LokerVisitor;
use Illuminate\Console\Command;
use Throwable;

class SyncLokerVisitors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loker:sync-visitors {--tenant= : The slug of the tenant} {--days=7 : Number of days to sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync visitor statistics from Umami using AnalyticsService and store to loker_visitor table';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $tenantSlug = $this->option('tenant');
        $days = (int) $this->option('days');

        if (!$tenantSlug) {
            $tenants = BaleList::all();
            if ($tenants->isEmpty()) {
                $this->error('No tenants found in bale_lists table.');
                return self::FAILURE;
            }

            $tenantSlug = $this->choice(
                'Which tenant database stats do you want to sync?',
                $tenants->pluck('slug')->toArray()
            );
        }

        try {
            $tenant = BaleList::where('slug', $tenantSlug)->firstOrFail();

            $this->info("Initializing connection for tenant: {$tenant->slug}");
            TenantManager::initializeFromBaleUuid($tenant->id);
            $connection = TenantManager::getActiveConnection();

            if (!$connection) {
                throw new \Exception("Failed to activate connection for tenant {$tenant->slug}");
            }

            // Set active session variables so that Umami configs can be resolved properly
            session(['bale_active_uuid' => $tenant->id]);
            session(['bale_active_slug' => $tenant->slug]);

            TenantConnectionService::ensureActive();

            $lokers = Loker::all();

            if ($lokers->isEmpty()) {
                $this->info("No job vacancies (loker) found for tenant {$tenant->slug}.");
                return self::SUCCESS;
            }

            $analyticsService = new AnalyticsService();
            $timezone = config('core.analytics.umami.timezone', 'Asia/Jakarta');

            $this->info("Fetching and syncing stats for " . $lokers->count() . " loker(s)...");
            $bar = $this->output->createProgressBar($lokers->count());
            $bar->start();

            $syncedCount = 0;

            foreach ($lokers as $loker) {
                // Default public path for loker detail: /loker/{slug}
                $path = "/loker/{$loker->slug}";

                $pathStats = $analyticsService->getPathStats($path, $days);

                if (!empty($pathStats['unavailable'])) {
                    continue;
                }

                $chartData = $pathStats['chart'];
                
                // Get general stats (bounce rate and avg session duration)
                $overview = $pathStats['overview'];
                $bounceRateStr = data_get($overview, 'bounce_rate', 'N/A');
                $bounceRate = $bounceRateStr !== 'N/A' ? (float) str_replace('%', '', $bounceRateStr) : null;
                
                $avgDurationStr = data_get($overview, 'avg_session_duration', 'N/A');
                $avgSeconds = null;
                if ($avgDurationStr !== 'N/A') {
                    // Quick parse from "Xm Ys" to total seconds
                    if (preg_match('/(?:(\d+)m)?\s*(?:(\d+)s)?/', $avgDurationStr, $matches)) {
                        $minutes = isset($matches[1]) ? (int)$matches[1] : 0;
                        $seconds = isset($matches[2]) ? (int)$matches[2] : 0;
                        $avgSeconds = ($minutes * 60) + $seconds;
                    }
                }

                foreach ($chartData['page_views'] as $index => $pageviewsCount) {
                    // Reconstruct date from the index order
                    $day = now($timezone)->subDays($days - 1 - $index);
                    $dateString = $day->format('Y-m-d');
                    
                    $visitorsCount = isset($chartData['visitors'][$index]) 
                        ? (int)$chartData['visitors'][$index] 
                        : 0;

                    // Only save if there's tracking activity to keep DB clean
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
                        $syncedCount++;
                    }
                }

                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            $this->info("Completed syncing visitor stats. Mapped {$syncedCount} daily record(s) for tenant {$tenant->slug}.");

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error("Sync failed: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}
