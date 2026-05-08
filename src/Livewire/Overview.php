<?php

namespace Bale\Loker\Livewire;

use Bale\Loker\Models\Loker;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Bale\Cms\Services\TenantConnectionService;
use Livewire\WithPagination;

#[Layout('cms::layouts.app')]
#[Title('Overview Lowongan Kerja')]
class Overview extends Component
{
    use WithPagination;

    public function mount(): void
    {
        TenantConnectionService::ensureActive();
    }

    public function render()
    {
        TenantConnectionService::ensureActive();
        
        $lokers = Loker::latest()->paginate(10);

        return view('loker::livewire.overview', [
            'lokers' => $lokers
        ]);
    }
}
