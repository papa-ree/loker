<div>
    <x-core::page-header 
        gradient 
        :title="__('Lowongan Kerja')" 
        :subtitle="__('Kelola informasi lowongan pekerjaan untuk masyarakat.')"
    >
        <x-slot name="action">
            <x-core::button link href="#" label="Tambah Loker">
                <x-slot name="icon">
                    <x-lucide-plus class="w-5 h-5" />
                </x-slot>
            </x-core::button>
        </x-slot>
    </x-core::page-header>

    <x-core::page-container>
        <div class="space-y-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="group p-6 transition-all duration-300 bg-white border border-gray-100 shadow-md dark:bg-gray-800 rounded-2xl hover:shadow-xl dark:border-gray-700 hover:-translate-y-1" data-aos="fade-up">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-linear-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg">
                            <x-lucide-briefcase class="w-6 h-6 text-white" />
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold text-indigo-700 bg-indigo-100 rounded-full dark:bg-indigo-900/50 dark:text-indigo-300">
                            Total
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Lowongan') }}</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ $lokers->total() }}</p>
                    </div>
                </div>

                <div class="group p-6 transition-all duration-300 bg-white border border-gray-100 shadow-md dark:bg-gray-800 rounded-2xl hover:shadow-xl dark:border-gray-700 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-linear-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg">
                            <x-lucide-check-circle class="w-6 h-6 text-white" />
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold text-emerald-700 bg-emerald-100 rounded-full dark:bg-emerald-900/50 dark:text-emerald-300">
                            Aktif
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Lowongan Aktif') }}</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ $lokers->where('actived', true)->count() }}</p>
                    </div>
                </div>

                <div class="group p-6 transition-all duration-300 bg-white border border-gray-100 shadow-md dark:bg-gray-800 rounded-2xl hover:shadow-xl dark:border-gray-700 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-linear-to-br from-rose-500 to-rose-600 rounded-xl shadow-lg">
                            <x-lucide-clock-alert class="w-6 h-6 text-white" />
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold text-rose-700 bg-rose-100 rounded-full dark:bg-rose-900/50 dark:text-rose-300">
                            Kadaluarsa
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Sudah Berakhir') }}</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ $lokers->filter(fn($l) => $l->is_expired)->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Daftar Lowongan') }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Kelola dan pantau seluruh lowongan yang tersedia.') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <x-core::table-search-input />
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-slate-900/50">
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">{{ __('Pekerjaan') }}</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">{{ __('Perusahaan') }}</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">{{ __('Lokasi') }}</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">{{ __('Masa Berlaku') }}</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">{{ __('Tipe / Kategori') }}</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">{{ __('Status') }}</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700 text-right">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($lokers as $loker)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $loker->nama_pekerjaan }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $loker->gaji ?? 'Gaji tidak disebutkan' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $loker->nama_perusahaan }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        <div class="flex items-center gap-1.5">
                                            <x-lucide-map-pin class="w-4 h-4 text-gray-400" />
                                            {{ $loker->lokasi }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        <div class="flex flex-col">
                                            @if($loker->tgl_berakhir)
                                                <span class="text-sm {{ $loker->is_expired ? 'text-rose-600 font-bold' : '' }}">
                                                    {{ $loker->tgl_berakhir->format('d M Y') }}
                                                </span>
                                                <span class="text-[10px] uppercase tracking-tighter text-gray-400">
                                                    {{ $loker->is_expired ? __('Sudah Berakhir') : __('Hingga') }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 italic text-xs">{{ __('Tidak diatur') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-md">
                                                {{ $loker->tipe }}
                                            </span>
                                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 rounded-md">
                                                {{ $loker->kategory }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($loker->is_expired)
                                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400">
                                                Expired
                                            </span>
                                        @elseif($loker->actived)
                                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-800/30 dark:text-emerald-400">
                                                <span class="relative flex h-2 w-2">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                                </span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400">
                                                Non-aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end items-center gap-2">
                                            <button class="p-2 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                                <x-lucide-edit-3 class="w-5 h-5" />
                                            </button>
                                            <button class="p-2 text-gray-400 hover:text-rose-600 dark:hover:text-rose-400 transition-colors">
                                                <x-lucide-trash-2 class="w-5 h-5" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12">
                                        <div class="text-center">
                                            <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                <x-lucide-inbox class="w-8 h-8 text-gray-400" />
                                            </div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ __('Belum ada data lowongan kerja') }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($lokers->hasPages())
                    <div class="p-6 border-t border-gray-100 dark:border-gray-700">
                        {{ $lokers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </x-core::page-container>
</div>
