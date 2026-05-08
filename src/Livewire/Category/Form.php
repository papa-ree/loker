<?php

namespace Bale\Loker\Livewire\Category;

use Bale\Loker\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Bale\Cms\Services\TenantConnectionService;
use Illuminate\Support\Str;

#[Layout('cms::layouts.app')]
class Form extends Component
{
    public ?string $categoryId = null;

    public string $name = '';
    public string $slug = '';
    public ?string $description = null;
    public ?string $icon = null;
    public bool $actived = true;

    public function mount(?string $id = null): void
    {
        TenantConnectionService::ensureActive();
        
        if ($id) {
            $this->categoryId = $id;
            $category = Category::findOrFail($id);
            
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->description = $category->description;
            $this->icon = $category->icon;
            $this->actived = $category->actived;
        }
    }

    public function updatedName($value): void
    {
        if (!$this->categoryId) {
            $this->slug = Str::slug($value);
        }
    }

    public function rules()
    {
        TenantConnectionService::ensureActive();
        $connection = TenantConnectionService::connection();

        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:' . $connection . '.loker_categories,slug,' . ($this->categoryId ?? 'NULL') . ',id',
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
                'icon' => $this->icon,
                'actived' => $this->actived,
            ];

            if ($this->categoryId) {
                Category::on($connection)->where('id', $this->categoryId)->update($data);
                $this->dispatch('toast', message: __('Kategori berhasil diperbarui!'), type: 'success');
            } else {
                Category::on($connection)->create($data);
                $this->dispatch('toast', message: __('Kategori berhasil ditambahkan!'), type: 'success');
            }

            \DB::commit();

            $this->redirect(route('loker.category.index'), navigate: true);
        } catch (\Throwable $th) {
            \DB::rollBack();
            info('Category save failed: ' . $th->getMessage());
            $this->dispatch('toast', message: __('Terjadi kesalahan saat menyimpan data.'), type: 'error');
        }
    }

    #[Title('Form Kategori')]
    public function render()
    {
        return view('loker::livewire.category.form');
    }
}
