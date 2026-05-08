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

class CategoryTable extends Component
{
    use WithPagination, WithoutUrlPagination, HasSafeDelete;

    protected string $modelClass = Category::class;

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

    #[On('refresh-category-table')]
    public function render()
    {
        return view('loker::livewire.category.section.table');
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
    public function availableCategories()
    {
        TenantConnectionService::ensureActive();
        $connection = TenantConnectionService::connection();
        
        return (new Category)
            ->setConnection($connection)
            ->where('name', 'like', '%' . $this->query . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
    }
}
