<?php

namespace Bale\Loker\Livewire\Loker\Section;

use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    #[On('refresh-loker-table')]
    public function render()
    {
        return view('loker::livewire.loker.section.table');
    }
}
