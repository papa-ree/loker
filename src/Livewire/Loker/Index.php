<?php

namespace Bale\Loker\Livewire\Loker;

use Bale\Cms\Services\TenantConnectionService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('cms::layouts.app')]
#[Title('Manajemen Lowongan Kerja')]
class Index extends Component
{
    public function mount(): void
    {
        TenantConnectionService::ensureActive();
    }

    public function render()
    {
        return view('loker::livewire.loker.index');
    }
}
