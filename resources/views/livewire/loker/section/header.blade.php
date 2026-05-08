<x-core::page-header 
    gradient 
    :title="__('Manajemen Lowongan')" 
    :subtitle="__('Daftar lowongan kerja yang dipublikasikan.')"
>
    <x-slot name="action">
        <x-core::button link href="{{ route('loker.loker.create') }}" label="Tambah Lowongan">
            <x-slot name="icon">
                <x-lucide-plus class="w-5 h-5" />
            </x-slot>
        </x-core::button>
    </x-slot>
</x-core::page-header>
