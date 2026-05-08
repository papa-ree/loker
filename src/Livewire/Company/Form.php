<?php

namespace Bale\Loker\Livewire\Company;

use Bale\Loker\Models\Company;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Bale\Cms\Services\TenantConnectionService;
use Illuminate\Support\Str;

#[Layout('cms::layouts.app')]
class Form extends Component
{
    public ?string $companyId = null;

    // Form fields
    public string $name = '';
    public string $slug = '';
    public ?string $logo = null;
    public ?string $website = null;
    public ?string $address = null;
    public ?string $description = null;
    public bool $actived = true;

    public function mount(?string $id = null): void
    {
        TenantConnectionService::ensureActive();
        
        if ($id) {
            $this->companyId = $id;
            $company = Company::findOrFail($id);
            
            $this->name = $company->name;
            $this->slug = $company->slug;
            $this->logo = $company->logo;
            $this->website = $company->website;
            $this->address = $company->address;
            $this->description = $company->description;
            $this->actived = $company->actived;
        }
    }

    public function updatedName($value): void
    {
        if (!$this->companyId) {
            $this->slug = Str::slug($value);
        }
    }

    public function rules()
    {
        TenantConnectionService::ensureActive();
        $connection = TenantConnectionService::connection();

        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:' . $connection . '.loker_companies,slug,' . ($this->companyId ?? 'NULL') . ',id',
            'website' => 'nullable|url',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
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
                'logo' => $this->logo,
                'website' => $this->website,
                'address' => $this->address,
                'description' => $this->description,
                'actived' => $this->actived,
            ];

            if ($this->companyId) {
                Company::on($connection)->where('id', $this->companyId)->update($data);
                $this->dispatch('toast', message: __('Perusahaan berhasil diperbarui!'), type: 'success');
            } else {
                Company::on($connection)->create($data);
                $this->dispatch('toast', message: __('Perusahaan berhasil ditambahkan!'), type: 'success');
            }

            \DB::commit();

            $this->redirect(route('loker.company.index'), navigate: true);
        } catch (\Throwable $th) {
            \DB::rollBack();
            info('Company save failed: ' . $th->getMessage());
            $this->dispatch('toast', message: __('Terjadi kesalahan saat menyimpan data.'), type: 'error');
        }
    }

    #[Title('Form Perusahaan')]
    public function render()
    {
        return view('loker::livewire.company.form');
    }
}
