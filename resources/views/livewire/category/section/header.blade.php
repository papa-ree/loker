<x-core::page-header 
    gradient 
    :title="__('Kategori Lowongan')" 
    :subtitle="__('Kelola kategori industri dan bidang pekerjaan.')"
>
    <x-slot name="action">
        <x-core::button link href="{{ route('loker.category.create') }}" label="{{ __('Tambah Kategori') }}">
            <x-slot name="icon">
                <x-lucide-plus class="w-5 h-5" />
            </x-slot>
        </x-core::button>
    </x-slot>
</x-core::page-header>
