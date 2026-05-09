<?php

namespace Bale\Loker\Livewire\Type\Section;

use Bale\Loker\Models\Type;
use Bale\Cms\Traits\HasSafeDelete;
use Bale\Cms\Services\TenantConnectionService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class Table extends Component
{
    #[On('refresh-type-table')]
    public function render()
    {
        return view('loker::livewire.type.section.table');
    }
}
