<?php

namespace Bale\Loker\Livewire\Type;

use Bale\Loker\Models\Type;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Bale\Cms\Services\TenantConnectionService;
use Illuminate\Support\Str;

#[Layout('cms::layouts.app')]
class Form extends Component
{
    public ?string $typeId = null;

    public string $name = '';
    public string $slug = '';
    public ?string $description = null;
    public bool $actived = true;

    public function mount(?string $id = null): void
    {
        TenantConnectionService::ensureActive();
        
        if ($id) {
            $this->typeId = $id;
            $type = Type::findOrFail($id);
            
            $this->name = $type->name;
            $this->slug = $type->slug;
            $this->description = $type->description;
            $this->actived = $type->actived;
        }
    }

    public function updatedName($value): void
    {
        if (!$this->typeId) {
            $this->slug = Str::slug($value);
        }
    }

    public function rules()
    {
        TenantConnectionService::ensureActive();
        $connection = TenantConnectionService::connection();

        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:' . $connection . '.loker_types,slug,' . ($this->typeId ?? 'NULL') . ',id',
        ];
    }

    public function save(): void
    {
        $this->validate();

        \DB::beginTransaction();

        try {
            TenantConnectionService::ensureActive();
            $connection = TenantConnectionService::connection();

            $data = [
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'actived' => $this->actived,
            ];

            if ($this->typeId) {
                Type::on($connection)->where('id', $this->typeId)->update($data);
                $this->dispatch('toast', message: __('Tipe berhasil diperbarui!'), type: 'success');
            } else {
                Type::on($connection)->create($data);
                $this->dispatch('toast', message: __('Tipe berhasil ditambahkan!'), type: 'success');
            }

            \DB::commit();

            $this->redirect(route('loker.type.index'), navigate: true);
        } catch (\Throwable $th) {
            \DB::rollBack();
            info('Type save failed: ' . $th->getMessage());
            $this->dispatch('toast', message: __('Terjadi kesalahan saat menyimpan data.'), type: 'error');
        }
    }

    #[Title('Form Tipe')]
    public function render()
    {
        return view('loker::livewire.type.form');
    }
}
