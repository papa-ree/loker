<?php

namespace Bale\Loker\Livewire\Company;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Bale\Loker\Models\Company;
use Bale\Cms\Services\TenantConnectionService;

#[Layout('cms::layouts.app')]
#[Title('Manajemen Perusahaan')]
class Index extends Component
{
    public function mount(): void
    {
        TenantConnectionService::ensureActive();
    }

    public function render()
    {
        return view('loker::livewire.company.index');
    }
}
