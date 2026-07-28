<?php

namespace Bale\Loker\Livewire\Type\Section;

use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    #[On('refresh-type-table')]
    public function render()
    {
        return view('loker::livewire.type.section.table');
    }
}
