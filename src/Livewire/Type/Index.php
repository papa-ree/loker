<?php

namespace Bale\Loker\Livewire\Type;

use Bale\Cms\Services\TenantConnectionService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('cms::layouts.app')]
#[Title('Tipe Pekerjaan')]
class Index extends Component
{
    public function mount(): void
    {
        TenantConnectionService::ensureActive();
    }

    public function render()
    {
        return view('loker::livewire.type.index');
    }
}
