<div x-data="{ 
    name: @entangle('name'), 
    slug: @entangle('slug')
}">
    <x-core::breadcrumb :items="[['label' => __('Tipe Pekerjaan'), 'route' => 'loker.type.index']]" :active="$typeId ? __('Edit Tipe') : __('Tambah Tipe')" />

    <div class="max-w-4xl mx-auto mt-6">
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-xl overflow-hidden">
            <!-- Header Banner -->
            <div
                class="p-6 border-b border-gray-100 dark:border-slate-800 bg-linear-to-r from-blue-50/50 to-cyan-50/50 dark:from-blue-900/10 dark:to-cyan-900/10">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    {{ $typeId ? __('Edit Tipe Pekerjaan') : __('Tambah Tipe Pekerjaan Baru') }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    {{ __('Contoh: Full-time, Part-time, Freelance, Kontrak.') }}
                </p>
            </div>

            <form wire:submit="save" class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="">
                        <x-core::input label="{{ __('Nama Tipe') }}" wire:model="name" x-model="name" required />
                        <x-core::input-error for="name" />
                    </div>
                    <div class="">
                        <x-core::input label="{{ __('Slug') }}" wire:model="slug" x-model="slug" x-slug="name"
                            required />
                        <x-core::input-error for="slug" />
                    </div>
                </div>

                <x-core::textarea label="{{ __('Deskripsi Tipe') }}" wire:model="description" rows="4" />

                <!-- Toggle Status Aktif -->
                <div
                    class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/30 rounded-xl border border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                            <x-lucide-toggle-right class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                        </div>
                        <div>
                            <label for="active-toggle"
                                class="text-sm font-bold text-gray-900 dark:text-white cursor-pointer">{{ __('Status Aktif') }}</label>
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider">
                                {{ __('Aktifkan agar tipe dapat dipilih di lowongan') }}
                            </p>
                        </div>
                    </div>
                    <label for="active-toggle" class="relative inline-block w-12 h-6 cursor-pointer">
                        <input type="checkbox" id="active-toggle" wire:model="actived" class="peer sr-only" />
                        <span
                            class="absolute inset-0 bg-gray-300 dark:bg-slate-700 rounded-full transition-colors duration-300 peer-checked:bg-emerald-500"></span>
                        <span
                            class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-sm transition-transform duration-300 peer-checked:translate-x-6"></span>
                    </label>
                </div>

                <!-- Footer Actions -->
                <div class="pt-6 border-t border-gray-100 dark:border-slate-800 flex items-center justify-between">
                    <x-core::secondary-button link href="{{ route('loker.type.index') }}" label="{{ __('Batal') }}" />
                    <x-core::button type="submit" label="{{ __('Simpan Tipe') }}" spinner="save">
                        <x-slot name="icon"><x-lucide-check class="w-4 h-4" /></x-slot>
                    </x-core::button>
                </div>
            </form>
        </div>
    </div>
</div>