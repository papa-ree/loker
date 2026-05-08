<x-core::page-header 
    gradient 
    :title="__('Tipe Pekerjaan')" 
    :subtitle="__('Kelola jenis kontrak kerja (Full-time, Freelance, dll).')"
>
    <x-slot name="action">
        <x-core::button link href="{{ route('loker.type.create') }}" label="{{ __('Tambah Tipe') }}">
            <x-slot name="icon">
                <x-lucide-plus class="w-5 h-5" />
            </x-slot>
        </x-core::button>
    </x-slot>
</x-core::page-header>
