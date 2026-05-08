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
            'active' => Loker::where('actived', true)->where(function($q) {
                $q->whereNull('tgl_berakhir')->orWhere('tgl_berakhir', '>=', now());
            })->count(),
            'expired' => Loker::where(function($q) {
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

        return view('loker::livewire.overview.index', [
            'stats' => $stats,
            'byCategory' => $byCategory,
            'byType' => $byType,
            'topCompanies' => $topCompanies,
            'latestLokers' => $latestLokers,
        ]);
    }
}
