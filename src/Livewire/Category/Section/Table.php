<?php

namespace Bale\Loker\Livewire\Category\Section;

use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    #[On('refresh-category-table')]
    public function render()
    {
        return view('loker::livewire.category.section.table');
    }
}
