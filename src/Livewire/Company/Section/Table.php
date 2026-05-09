<?php

namespace Bale\Loker\Livewire\Company\Section;

use Bale\Loker\Models\Company;
use Bale\Cms\Traits\HasSafeDelete;
use Bale\Cms\Services\TenantConnectionService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class Table extends Component
{
    #[On('refresh-company-table')]
    public function render()
    {
        return view('loker::livewire.company.section.table');
    }
}
