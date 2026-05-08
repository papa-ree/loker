<x-core::page-header 
    gradient 
    :title="__('Manajemen Perusahaan')" 
    :subtitle="__('Daftar perusahaan mitra penyedia lowongan kerja.')"
>
    <x-slot name="action">
        <x-core::button link href="{{ route('loker.company.create') }}" label="{{ __('Tambah Perusahaan') }}">
            <x-slot name="icon">
                <x-lucide-plus class="w-5 h-5" />
            </x-slot>
        </x-core::button>
    </x-slot>
</x-core::page-header>
