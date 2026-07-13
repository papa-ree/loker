<div>
    <x-core::page-header gradient :title="__('Dashboard Analitik Lowongan')" :subtitle="__('Wawasan mendalam mengenai tren, kategori, dan aktivitas rekrutmen.')">
        <x-slot name="action">
            <div class="flex items-center gap-3">
                <x-core::secondary-button link href="{{ route('loker.company.index') }}"
                    label="{{ __('Kelola Mitra') }}">
                    <x-slot name="icon"><x-lucide-building-2 class="w-4 h-4" /></x-slot>
                </x-core::secondary-button>
                <x-core::button link href="{{ route('loker.loker.index') }}" label="{{ __('Manajemen Loker') }}">
                    <x-slot name="icon"><x-lucide-settings class="w-4 h-4" /></x-slot>
                </x-core::button>
            </div>
        </x-slot>
    </x-core::page-header>

    <div class="space-y-10 pb-10">

        {{-- ── TOP STATS GRID ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Lowongan -->
            <div class="relative group overflow-hidden p-6 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-1"
                data-aos="fade-up">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-50 dark:bg-indigo-900/10 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-700">
                </div>
                <div class="relative flex items-center justify-between mb-5">
                    <div
                        class="p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl group-hover:bg-indigo-600 transition-colors duration-300">
                        <x-lucide-briefcase
                            class="w-6 h-6 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" />
                    </div>
                    <div class="flex flex-col items-end">
                        <span
                            class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">{{ __('Total') }}</span>
                        <div class="flex items-center gap-1 text-emerald-500 text-xs font-bold">
                            <x-lucide-trending-up class="w-3 h-3" />
                            <span>12%</span>
                        </div>
                    </div>
                </div>
                <h4 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ number_format($stats['total']) }}</h4>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1">{{ __('Lowongan Terdaftar') }}
                </p>
            </div>

            <!-- Aktif -->
            <div class="relative group overflow-hidden p-6 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-1"
                data-aos="fade-up" data-aos-delay="100">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 dark:bg-emerald-900/10 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-700">
                </div>
                <div class="relative flex items-center justify-between mb-5">
                    <div
                        class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl group-hover:bg-emerald-500 transition-colors duration-300">
                        <x-lucide-check-circle
                            class="w-6 h-6 text-emerald-600 dark:text-emerald-400 group-hover:text-white transition-colors" />
                    </div>
                    <div class="flex flex-col items-end">
                        <span
                            class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">{{ __('Live') }}</span>
                        <span
                            class="px-2 py-0.5 bg-emerald-100 dark:bg-emerald-900/40 text-[9px] font-black text-emerald-700 dark:text-emerald-300 rounded-full">ACTIVE</span>
                    </div>
                </div>
                <h4 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ number_format($stats['active']) }}</h4>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1">{{ __('Sedang Tayang') }}</p>
            </div>

            <!-- Perusahaan -->
            <div class="relative group overflow-hidden p-6 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-1"
                data-aos="fade-up" data-aos-delay="200">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 dark:bg-amber-900/10 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-700">
                </div>
                <div class="relative flex items-center justify-between mb-5">
                    <div
                        class="p-3 bg-amber-100 dark:bg-amber-900/30 rounded-xl group-hover:bg-amber-500 transition-colors duration-300">
                        <x-lucide-building-2
                            class="w-6 h-6 text-amber-600 dark:text-amber-400 group-hover:text-white transition-colors" />
                    </div>
                    <div class="flex flex-col items-end">
                        <span
                            class="text-[10px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-widest">{{ __('Mitra') }}</span>
                        <div class="flex items-center gap-1 text-slate-400 text-xs font-bold">
                            <span>{{ $stats['companies'] }}</span>
                            <span class="font-normal">{{ __('Entity') }}</span>
                        </div>
                    </div>
                </div>
                <h4 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ number_format($stats['companies']) }}</h4>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1">{{ __('Perusahaan Tergabung') }}
                </p>
            </div>

            <!-- Expired -->
            <div class="relative group overflow-hidden p-6 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-1"
                data-aos="fade-up" data-aos-delay="300">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-rose-50 dark:bg-rose-900/10 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-700">
                </div>
                <div class="relative flex items-center justify-between mb-5">
                    <div
                        class="p-3 bg-rose-100 dark:bg-rose-900/30 rounded-xl group-hover:bg-rose-500 transition-colors duration-300">
                        <x-lucide-clock-alert
                            class="w-6 h-6 text-rose-600 dark:text-rose-400 group-hover:text-white transition-colors" />
                    </div>
                    <div class="flex flex-col items-end">
                        <span
                            class="text-[10px] font-bold text-rose-600 dark:text-rose-400 uppercase tracking-widest">{{ __('Selesai') }}</span>
                        <span
                            class="text-rose-500 font-bold text-[11px]">{{ number_format(($stats['expired'] / max(1, $stats['total'])) * 100, 1) }}%</span>
                    </div>
                </div>
                <h4 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ number_format($stats['expired']) }}</h4>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1">{{ __('Batas Waktu Berakhir') }}
                </p>
            </div>
        </div>

        {{-- ── ANALYTICS GRID ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- LEFT COLUMN: Distributions --}}
            <div class="lg:col-span-8 space-y-8" x-data="{ activeTab: 'category' }">

                {{-- Distributions Card --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md p-8"
                    data-aos="fade-up">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-10">
                        <div>
                            <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">
                                {{ __('Analisis Distribusi') }}</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                {{ __('Pembagian lowongan berdasarkan kategori dan tipe pekerjaan.') }}</p>
                        </div>
                        <div class="flex bg-slate-100 dark:bg-slate-800 p-1 rounded-xl w-fit">
                            <button @click="activeTab = 'category'"
                                :class="activeTab === 'category' ? 'bg-white dark:bg-slate-700 shadow-sm text-indigo-600 dark:text-white' : 'text-slate-500 dark:text-slate-400 hover:text-indigo-600'"
                                class="px-4 py-2 text-xs font-bold rounded-lg transition-all duration-200">
                                {{ __('Kategori') }}
                            </button>
                            <button @click="activeTab = 'type'"
                                :class="activeTab === 'type' ? 'bg-white dark:bg-slate-700 shadow-sm text-emerald-600 dark:text-white' : 'text-slate-500 dark:text-slate-400 hover:text-emerald-600'"
                                class="px-4 py-2 text-xs font-bold rounded-lg transition-all duration-200">
                                {{ __('Tipe') }}
                            </button>
                        </div>
                    </div>

                    <div class="relative min-h-[300px]">
                        {{-- By Category --}}
                        <div x-show="activeTab === 'category'" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                            <div class="flex items-center gap-2 mb-2">
                                <x-lucide-tag class="w-4 h-4 text-indigo-500" />
                                <span
                                    class="text-xs font-black uppercase tracking-widest text-slate-400">{{ __('Top Kategori') }}</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                                @forelse($byCategory->take(10) as $cat)
                                    <div class="group">
                                        <div class="flex justify-between items-end mb-2">
                                            <span
                                                class="text-sm font-bold text-slate-700 dark:text-slate-300 group-hover:text-indigo-600 transition-colors">{{ $cat->kategory ?: __('Umum') }}</span>
                                            <span class="text-xs font-black text-slate-400">{{ $cat->total }}</span>
                                        </div>
                                        <div class="h-2 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                            <div class="h-full bg-indigo-500 rounded-full group-hover:bg-indigo-600 transition-all duration-1000"
                                                style="width: {{ ($cat->total / max(1, $stats['total'])) * 100 }}%"></div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 italic">{{ __('Belum ada data kategori.') }}</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- By Type --}}
                        <div x-show="activeTab === 'type'" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="space-y-6">
                            <div class="flex items-center gap-2 mb-2">
                                <x-lucide-layers class="w-4 h-4 text-emerald-500" />
                                <span
                                    class="text-xs font-black uppercase tracking-widest text-slate-400">{{ __('Tipe Pekerjaan') }}</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                                @forelse($byType->take(10) as $type)
                                    <div class="group">
                                        <div class="flex justify-between items-end mb-2">
                                            <span
                                                class="text-sm font-bold text-slate-700 dark:text-slate-300 group-hover:text-emerald-600 transition-colors">{{ $type->tipe ?: __('Lainnya') }}</span>
                                            <span class="text-xs font-black text-slate-400">{{ $type->total }}</span>
                                        </div>
                                        <div class="h-2 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                            <div class="h-full bg-emerald-500 rounded-full group-hover:bg-emerald-600 transition-all duration-1000"
                                                style="width: {{ ($type->total / max(1, $stats['total'])) * 100 }}%"></div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 italic">{{ __('Belum ada data tipe.') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Top Companies --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md p-8"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">
                                {{ __('Top Kontributor Mitra') }}
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                {{ __('Perusahaan dengan jumlah lowongan terbanyak.') }}
                            </p>
                        </div>
                        <x-core::secondary-button link href="{{ route('loker.company.index') }}"
                            label="{{ __('Lihat Semua') }}" size="sm" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($topCompanies as $company)
                            <div
                                class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50 flex flex-col items-center text-center group hover:bg-white dark:hover:bg-slate-800 hover:shadow-xl transition-all duration-300">
                                <div
                                    class="w-14 h-14 rounded-full bg-white dark:bg-slate-700 shadow-md flex items-center justify-center mb-4 ring-4 ring-indigo-50 dark:ring-indigo-900/20 group-hover:scale-110 transition-transform">
                                    <x-lucide-building-2 class="w-7 h-7 text-indigo-500" />
                                </div>
                                <h5 class="text-sm font-black text-slate-900 dark:text-white line-clamp-1">
                                    {{ $company->nama_perusahaan }}
                                </h5>
                                <div class="mt-2 px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 rounded-full">
                                    <span
                                        class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400">{{ $company->total }}
                                        {{ __('Lowongan') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Latest Activity --}}
            <div class="lg:col-span-4 space-y-8">

                {{-- Latest Activity Card --}}
                <div class="bg-indigo-600 dark:bg-indigo-700 rounded-2xl shadow-xl shadow-indigo-200 dark:shadow-none p-8 text-white relative overflow-hidden"
                    data-aos="fade-left">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute -left-10 -top-10 w-40 h-40 bg-indigo-400/20 rounded-full blur-3xl"></div>

                    <div class="relative">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xl font-black tracking-tight">{{ __('Aktivitas Terbaru') }}</h3>
                            <div class="p-2 bg-white/20 rounded-xl backdrop-blur-md">
                                <x-lucide-history class="w-5 h-5 text-white" />
                            </div>
                        </div>

                        <div class="space-y-6">
                            @foreach($latestLokers as $loker)
                                <div class="flex gap-4 group">
                                    <div class="flex flex-col items-center gap-2">
                                        <div
                                            class="w-2 h-2 rounded-full bg-white group-hover:scale-150 transition-transform shadow-[0_0_8px_rgba(255,255,255,0.8)]">
                                        </div>
                                        @if(!$loop->last)
                                            <div class="w-px h-12 bg-white/20"></div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div
                                            class="p-4 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/10 group-hover:bg-white/20 transition-all duration-300">
                                            <h6 class="text-sm font-bold leading-tight">{{ $loker->nama_pekerjaan }}
                                            </h6>
                                            <p class="text-[11px] text-indigo-100 mt-1 opacity-80">
                                                {{ $loker->nama_perusahaan }}
                                            </p>
                                            <div class="flex items-center justify-between mt-3">
                                                <span
                                                    class="text-[10px] px-2 py-0.5 bg-white/20 rounded-md font-bold">{{ $loker->tipe ?: __('N/A') }}</span>
                                                <span
                                                    class="text-[10px] opacity-60 italic">{{ $loker->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-10">
                            <x-core::button link href="{{ route('loker.loker.index') }}" variant="white" full
                                class="!rounded-2xl !py-4 shadow-lg shadow-indigo-800/20"
                                label="{{ __('Buka Manajemen Loker') }}">
                                <x-slot name="icon"><x-lucide-arrow-right class="w-4 h-4" /></x-slot>
                            </x-core::button>
                        </div>
                    </div>
                </div>

                {{-- Quick Links / Master Card --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm p-8"
                    data-aos="fade-up" data-aos-delay="200">
                    <h4 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-6">
                        {{ __('Master Data') }}
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('loker.category.index') }}"
                            class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex flex-col items-center justify-center gap-2 group hover:border-indigo-300 dark:hover:border-indigo-700 transition-colors">
                            <x-lucide-tag class="w-6 h-6 text-indigo-500 group-hover:scale-110 transition-transform" />
                            <span
                                class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ __('Kategori') }}</span>
                            <span
                                class="text-[10px] px-2 py-0.5 bg-white dark:bg-slate-700 rounded-full shadow-sm text-slate-400">{{ $stats['total_categories'] }}</span>
                        </a>
                        <a href="{{ route('loker.type.index') }}"
                            class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex flex-col items-center justify-center gap-2 group hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                            <x-lucide-layers
                                class="w-6 h-6 text-emerald-500 group-hover:scale-110 transition-transform" />
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ __('Tipe') }}</span>
                            <span
                                class="text-[10px] px-2 py-0.5 bg-white dark:bg-slate-700 rounded-full shadow-sm text-slate-400">{{ $stats['total_types'] }}</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── VISITOR ANALYTICS SECTION ── --}}
        <div class="space-y-6" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-violet-100 dark:bg-violet-900/30 rounded-xl">
                    <x-lucide-bar-chart-2 class="w-5 h-5 text-violet-600 dark:text-violet-400" />
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">{{ __('Analitik Kunjungan Loker') }}</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Data pageview & visitor per lowongan dari Umami Analytics.') }}</p>
                </div>
                <div class="ml-auto">
                    <span class="text-[10px] font-bold uppercase tracking-widest px-3 py-1 bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 rounded-full">
                        {{ __('30 Hari Terakhir') }}
                    </span>
                </div>
            </div>

            {{-- Stat Cards: Total Pageviews & Visitors --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Total Pageviews --}}
                <div class="relative group overflow-hidden p-6 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-1">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-violet-50 dark:bg-violet-900/10 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-700"></div>
                    <div class="relative flex items-center justify-between mb-5">
                        <div class="p-3 bg-violet-100 dark:bg-violet-900/30 rounded-xl group-hover:bg-violet-600 transition-colors duration-300">
                            <x-lucide-eye class="w-6 h-6 text-violet-600 dark:text-violet-400 group-hover:text-white transition-colors" />
                        </div>
                        <span class="text-[10px] font-bold text-violet-600 dark:text-violet-400 uppercase tracking-widest">{{ __('Total') }}</span>
                    </div>
                    <h4 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                        {{ number_format($visitorAggregate->total_pageviews ?? 0) }}
                    </h4>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1">{{ __('Total Pageview Loker') }}</p>
                </div>

                {{-- Total Unique Visitors --}}
                <div class="relative group overflow-hidden p-6 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-1">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-sky-50 dark:bg-sky-900/10 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-700"></div>
                    <div class="relative flex items-center justify-between mb-5">
                        <div class="p-3 bg-sky-100 dark:bg-sky-900/30 rounded-xl group-hover:bg-sky-600 transition-colors duration-300">
                            <x-lucide-users class="w-6 h-6 text-sky-600 dark:text-sky-400 group-hover:text-white transition-colors" />
                        </div>
                        <span class="text-[10px] font-bold text-sky-600 dark:text-sky-400 uppercase tracking-widest">{{ __('Unik') }}</span>
                    </div>
                    <h4 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                        {{ number_format($visitorAggregate->total_visitors ?? 0) }}
                    </h4>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1">{{ __('Total Pengunjung Unik') }}</p>
                </div>
            </div>

            {{-- Chart + Top Loker grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                {{-- Chart 30 hari --}}
                <div class="lg:col-span-7 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h4 class="text-base font-black text-slate-900 dark:text-white">{{ __('Tren Kunjungan') }}</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ __('Pageview & visitor harian semua loker') }}</p>
                        </div>
                        <div class="flex items-center gap-4 text-[11px] text-slate-500 dark:text-slate-400">
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-1 rounded-full bg-violet-500 inline-block"></span>{{ __('Pageviews') }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-1 rounded-full bg-sky-400 inline-block"></span>{{ __('Visitors') }}
                            </span>
                        </div>
                    </div>
                    <div wire:ignore>
                        <canvas id="loker-visitor-chart" height="220"></canvas>
                    </div>
                </div>

                {{-- Top Loker by Pageviews --}}
                <div class="lg:col-span-5 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="text-base font-black text-slate-900 dark:text-white">{{ __('Top Loker Dikunjungi') }}</h4>
                        <x-lucide-trophy class="w-5 h-5 text-amber-400" />
                    </div>

                    @if($topLokerByViews->isEmpty())
                        <div class="flex flex-col items-center justify-center py-10 text-slate-400">
                            <x-lucide-bar-chart class="w-10 h-10 mb-3 opacity-30" />
                            <p class="text-sm italic">{{ __('Belum ada data kunjungan.') }}</p>
                            <p class="text-xs mt-1 opacity-60">{{ __('Jalankan loker:sync-visitors untuk sinkronisasi.') }}</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($topLokerByViews as $index => $item)
                                @php
                                    $maxViews = $topLokerByViews->max('total_pageviews') ?: 1;
                                    $pct      = round(($item->total_pageviews / $maxViews) * 100);
                                    $colors   = ['bg-violet-500','bg-sky-500','bg-emerald-500','bg-amber-500','bg-rose-500'];
                                    $color    = $colors[$index % 5];
                                @endphp
                                <div class="group">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <span class="shrink-0 w-5 h-5 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[10px] font-black text-slate-500">
                                                {{ $index + 1 }}
                                            </span>
                                            <div class="min-w-0">
                                                <p class="text-sm font-bold text-slate-800 dark:text-slate-200 truncate group-hover:text-violet-600 transition-colors">
                                                    {{ $item->nama_pekerjaan }}
                                                </p>
                                                <p class="text-[11px] text-slate-400 truncate">{{ $item->nama_perusahaan }}</p>
                                            </div>
                                        </div>
                                        <div class="shrink-0 ml-2 text-right">
                                            <p class="text-sm font-black text-slate-700 dark:text-slate-300">{{ number_format($item->total_pageviews) }}</p>
                                            <p class="text-[10px] text-slate-400">{{ number_format($item->total_visitors) }} unik</p>
                                        </div>
                                    </div>
                                    <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                        <div class="h-full {{ $color }} rounded-full transition-all duration-1000" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('loker-visitor-chart');
    if (!ctx) return;

    const labels    = @js($visitorChart['labels']);
    const pageviews = @js($visitorChart['pageviews']);
    const visitors  = @js($visitorChart['visitors']);

    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const labelColor = isDark ? '#94a3b8' : '#64748b';

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Pageviews',
                    data: pageviews,
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139,92,246,0.12)',
                    borderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: 'Visitors',
                    data: visitors,
                    borderColor: '#38bdf8',
                    backgroundColor: 'rgba(56,189,248,0.10)',
                    borderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    fill: true,
                    tension: 0.4,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDark ? '#1e293b' : '#fff',
                    borderColor: isDark ? '#334155' : '#e2e8f0',
                    borderWidth: 1,
                    titleColor: labelColor,
                    bodyColor: labelColor,
                    padding: 10,
                },
            },
            scales: {
                x: {
                    ticks: {
                        color: labelColor,
                        maxTicksLimit: 8,
                        font: { size: 10 },
                    },
                    grid: { color: gridColor },
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: labelColor,
                        font: { size: 10 },
                        precision: 0,
                    },
                    grid: { color: gridColor },
                },
            },
        },
    });
});
</script>
@endpush