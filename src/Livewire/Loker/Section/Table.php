<?php

namespace Bale\Loker\Livewire\Loker\Section;

use Bale\Loker\Models\Loker;
use Bale\Cms\Traits\HasSafeDelete;
use Bale\Cms\Services\TenantConnectionService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class Table extends Component
{
    #[On('refresh-loker-table')]
    public function render()
    {
        return view('loker::livewire.loker.section.table');
    }
}
