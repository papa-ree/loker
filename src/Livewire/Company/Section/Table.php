<?php

namespace Bale\Loker\Livewire\Company\Section;

use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    #[On('refresh-company-table')]
    public function render()
    {
        return view('loker::livewire.company.section.table');
    }
}
