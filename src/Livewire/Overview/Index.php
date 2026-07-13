<?php

namespace Bale\Loker\Livewire\Overview;

use Bale\Loker\Models\Loker;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Bale\Cms\Services\TenantConnectionService;
use Illuminate\Support\Facades\DB;

#[Layout('cms::layouts.app')]
#[Title('Statistik Lowongan Kerja')]
class Index extends Component
{
    public function mount(): void
    {
        TenantConnectionService::ensureActive();
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
            'companies' => \Bale\Loker\Models\Company::on($connection)->count(),
            'total_categories' => \Bale\Loker\Models\Category::on($connection)->count(),
            'total_types' => \Bale\Loker\Models\Type::on($connection)->count(),
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
        $latestLokers = Loker::latest()->take(6)->get();

        // ── Visitor Analytics per-Loker ────────────────────────────────────
        // Aggregate total kunjungan khusus loker_visitor
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

        // Chart 30 hari: harian aggregate semua loker
        $chartDays = 30;
        $timezone  = config('core.analytics.umami.timezone', 'Asia/Jakarta');
        $startDate = now($timezone)->subDays($chartDays - 1)->startOfDay()->format('Y-m-d');

        $rawChart = DB::connection($connection)
            ->table('loker_visitor')
            ->selectRaw('date, SUM(pageviews) as pageviews, SUM(visitors) as visitors')
            ->where('date', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy(fn ($row) => $row->date);

        $chartLabels = $chartPageviews = $chartVisitors = [];
        for ($i = $chartDays - 1; $i >= 0; $i--) {
            $day = now($timezone)->subDays($i);
            $key = $day->format('Y-m-d');
            $chartLabels[]    = $day->format('M d');
            $chartPageviews[] = (int) ($rawChart->get($key)?->pageviews ?? 0);
            $chartVisitors[]  = (int) ($rawChart->get($key)?->visitors ?? 0);
        }

        return view('loker::livewire.overview.index', [
            'stats'             => $stats,
            'byCategory'        => $byCategory,
            'byType'            => $byType,
            'topCompanies'      => $topCompanies,
            'latestLokers'      => $latestLokers,
            // visitor
            'visitorAggregate'  => $visitorAggregate,
            'topLokerByViews'   => $topLokerByViews,
            'visitorChart'      => [
                'labels'    => $chartLabels,
                'pageviews' => $chartPageviews,
                'visitors'  => $chartVisitors,
            ],
        ]);
    }
}
