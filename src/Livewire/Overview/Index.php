<?php

namespace Bale\Loker\Livewire\Overview;

use Bale\Cms\Services\TenantConnectionService;
use Bale\Loker\Jobs\SyncLokerVisitorsJob;
use Bale\Loker\Models\Category;
use Bale\Loker\Models\Company;
use Bale\Loker\Models\Loker;
use Bale\Loker\Models\Type;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('cms::layouts.app')]
#[Title('Statistik Lowongan Kerja')]
class Index extends Component
{
    public int $chartDays = 30;

    public function mount(): void
    {
        TenantConnectionService::ensureActive();
    }

    public function updatedChartDays(): void
    {
        $this->dispatch('chartUpdated');
    }

    public function syncVisitors(): void
    {
        try {
            $baleUuid = session('bale_active_uuid');

            if (! $baleUuid) {
                $this->dispatch('toast', message: __('Tenant tidak aktif.'), type: 'error');

                return;
            }

            SyncLokerVisitorsJob::dispatch($baleUuid, $this->chartDays);

            $this->dispatch('toast', message: __('Sinkronisasi data kunjungan sedang diproses.'), type: 'success');
        } catch (\Throwable $e) {
            $this->dispatch('toast', message: __('Gagal menjalankan sinkronisasi: ').$e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        TenantConnectionService::ensureActive();
        $connection = TenantConnectionService::connection();

        $stats = [
            'total' => Loker::count(),
            'active' => Loker::where('actived', true)->where(function ($q) {
                $q->whereNull('tgl_berakhir')->orWhere('tgl_berakhir', '>=', now());
            })->count(),
            'expired' => Loker::where(function ($q) {
                $q->whereNotNull('tgl_berakhir')->where('tgl_berakhir', '<', now());
            })->count(),
            'companies' => Company::on($connection)->count(),
            'total_categories' => Category::on($connection)->count(),
            'total_types' => Type::on($connection)->count(),
        ];

        // Group by category
        $byCategory = Loker::select('kategory', DB::raw('count(*) as total'))
            ->groupBy('kategory')
            ->orderByDesc('total')
            ->get();

        // Group by type
        $byType = Loker::select('tipe', DB::raw('count(*) as total'))
            ->groupBy('tipe')
            ->orderByDesc('total')
            ->get();

        // Top Companies
        $topCompanies = Loker::select('nama_perusahaan', DB::raw('count(*) as total'))
            ->groupBy('nama_perusahaan')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Latest entries
        $latestLokers = Loker::latest()->take(4)->get();

        // ── Visitor Analytics per-Loker ────────────────────────────────────
        $visitorAggregate = DB::connection($connection)
            ->table('loker_visitor')
            ->selectRaw('
                COALESCE(SUM(pageviews), 0) as total_pageviews,
                COALESCE(SUM(visitors), 0)  as total_visitors
            ')
            ->first();

        // Top 5 loker paling banyak dikunjungi
        $topLokerByViews = DB::connection($connection)
            ->table('loker_visitor')
            ->join('loker', 'loker_visitor.loker_slug', '=', 'loker.slug')
            ->whereNull('loker.deleted_at')
            ->select(
                'loker.id',
                'loker.slug',
                'loker.nama_pekerjaan',
                'loker.nama_perusahaan',
                DB::raw('SUM(loker_visitor.pageviews) as total_pageviews'),
                DB::raw('SUM(loker_visitor.visitors) as total_visitors')
            )
            ->groupBy('loker.id', 'loker.slug', 'loker.nama_pekerjaan', 'loker.nama_perusahaan')
            ->orderByDesc('total_pageviews')
            ->take(5)
            ->get();

        // Chart: harian aggregate semua loker
        $chartDays = $this->chartDays;
        $timezone = config('core.analytics.umami.timezone', 'Asia/Jakarta');
        $startDate = now($timezone)->subDays($chartDays - 1)->startOfDay()->format('Y-m-d');

        $rawChart = DB::connection($connection)
            ->table('loker_visitor')
            ->selectRaw('DATE_FORMAT(date, \'%Y-%m-%d\') as date_key, SUM(pageviews) as pageviews, SUM(visitors) as visitors')
            ->where('date', '>=', $startDate)
            ->groupBy('date_key')
            ->orderBy('date_key')
            ->get()
            ->keyBy('date_key');

        $chartLabels = $chartPageviews = $chartVisitors = [];
        for ($i = $chartDays - 1; $i >= 0; $i--) {
            $day = now($timezone)->subDays($i);
            $key = $day->format('Y-m-d');
            $chartLabels[] = $day->format('M d');
            $chartPageviews[] = (int) ($rawChart->get($key)?->pageviews ?? 0);
            $chartVisitors[] = (int) ($rawChart->get($key)?->visitors ?? 0);
        }

        return view('loker::livewire.overview.index', [
            'stats' => $stats,
            'byCategory' => $byCategory,
            'byType' => $byType,
            'topCompanies' => $topCompanies,
            'latestLokers' => $latestLokers,
            'visitorAggregate' => $visitorAggregate,
            'topLokerByViews' => $topLokerByViews,
            'visitorChart' => [
                'labels' => $chartLabels,
                'pageviews' => $chartPageviews,
                'visitors' => $chartVisitors,
            ],
        ]);
    }
}
