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

class LokerTable extends Component
{
    use WithPagination, WithoutUrlPagination, HasSafeDelete;

    protected string $modelClass = Loker::class;

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

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

    #[On('refresh-loker-table')]
    public function render()
    {
        return view('loker::livewire.loker.section.table');
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
    public function availableLokers()
    {
        TenantConnectionService::ensureActive();
        $connection = TenantConnectionService::connection();
        
        return (new Loker)
            ->setConnection($connection)
            ->where('nama_pekerjaan', 'like', '%' . $this->query . '%')
            ->orWhere('nama_perusahaan', 'like', '%' . $this->query . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
    }
}
