<?php

namespace Bale\Loker\Livewire\Category\Section;

use Bale\Loker\Models\Category;
use Bale\Cms\Traits\HasSafeDelete;
use Bale\Cms\Services\TenantConnectionService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class Table extends Component
{
    #[On('refresh-category-table')]
    public function render()
    {
        return view('loker::livewire.category.section.table');
    }
}
