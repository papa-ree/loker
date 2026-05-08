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

class TypeTable extends Component
{
    use WithPagination, WithoutUrlPagination, HasSafeDelete;

    protected string $modelClass = Type::class;

    public $query = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public function sort($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetAllFilters()
    {
        $this->reset(['query']);
    }

    #[On('refresh-type-table')]
    public function render()
    {
        return view('loker::livewire.type.section.table');
    }

    public function updating($key): void
    {
        if ($key === 'query') {
            $this->resetPage();
        }
    }

    public function updatedPage()
    {
        $this->dispatch('paginated');
    }

    #[Computed]
    public function availableTypes()
    {
        TenantConnectionService::ensureActive();
        $connection = TenantConnectionService::connection();
        
        return (new Type)
            ->setConnection($connection)
            ->where('name', 'like', '%' . $this->query . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
    }
}
