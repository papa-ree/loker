<div>
    {{-- ── HEADER ── --}}
    <x-core::page-header :title="__('Dashboard Analitik Lowongan')" :subtitle="__('Wawasan mendalam mengenai tren, kategori, dan aktivitas rekrutmen.')">
        <x-slot name="action">
            <div class="flex items-center gap-2">
                <x-core::secondary-button
                    wire:click="syncVisitors"
                    wire:loading.attr="disabled"
                    label="{{ __('Sinkronkan Data') }}">
                    <x-slot name="icon">
                        <x-lucide-refresh-cw class="w-4 h-4" wire:loading.class="animate-spin" wire:target="syncVisitors" />
                    </x-slot>
                </x-core::secondary-button>
                <x-core::secondary-button link href="{{ route('loker.company.index') }}"
                    label="{{ __('Mitra') }}">
                    <x-slot name="icon"><x-lucide-building-2 class="w-4 h-4" /></x-slot>
                </x-core::secondary-button>
                <x-core::button link href="{{ route('loker.loker.index') }}" label="{{ __('Loker') }}">
                    <x-slot name="icon"><x-lucide-briefcase class="w-4 h-4" /></x-slot>
                </x-core::button>
            </div>
        </x-slot>
    </x-core::page-header>

    <div class="space-y-6 pb-8">

        {{-- ── TOP STATS ── --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total --}}
            <div class="relative group overflow-hidden p-4 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md hover:shadow-lg transition-all duration-300">
                <div class="absolute -right-3 -top-3 w-16 h-16 bg-indigo-50 dark:bg-indigo-900/10 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="relative flex items-center gap-3 mb-3">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg group-hover:bg-indigo-600 transition-colors duration-300">
                        <x-lucide-briefcase class="w-5 h-5 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" />
                    </div>
                    <span class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">{{ __('Total') }}</span>
                </div>
                <h4 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">{{ number_format($stats['total']) }}</h4>
                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-0.5">{{ __('Lowongan Terdaftar') }}</p>
            </div>

            {{-- Aktif --}}
            <div class="relative group overflow-hidden p-4 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md hover:shadow-lg transition-all duration-300">
                <div class="absolute -right-3 -top-3 w-16 h-16 bg-emerald-50 dark:bg-emerald-900/10 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="relative flex items-center gap-3 mb-3">
                    <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg group-hover:bg-emerald-500 transition-colors duration-300">
                        <x-lucide-check-circle class="w-5 h-5 text-emerald-600 dark:text-emerald-400 group-hover:text-white transition-colors" />
                    </div>
                    <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">{{ __('Live') }}</span>
                </div>
                <h4 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">{{ number_format($stats['active']) }}</h4>
                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-0.5">{{ __('Sedang Tayang') }}</p>
            </div>

            {{-- Mitra --}}
            <div class="relative group overflow-hidden p-4 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md hover:shadow-lg transition-all duration-300">
                <div class="absolute -right-3 -top-3 w-16 h-16 bg-amber-50 dark:bg-amber-900/10 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="relative flex items-center gap-3 mb-3">
                    <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg group-hover:bg-amber-500 transition-colors duration-300">
                        <x-lucide-building-2 class="w-5 h-5 text-amber-600 dark:text-amber-400 group-hover:text-white transition-colors" />
                    </div>
                    <span class="text-[10px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-widest">{{ __('Mitra') }}</span>
                </div>
                <h4 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">{{ number_format($stats['companies']) }}</h4>
                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-0.5">{{ __('Perusahaan Tergabung') }}</p>
            </div>

            {{-- Expired --}}
            <div class="relative group overflow-hidden p-4 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md hover:shadow-lg transition-all duration-300">
                <div class="absolute -right-3 -top-3 w-16 h-16 bg-rose-50 dark:bg-rose-900/10 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="relative flex items-center gap-3 mb-3">
                    <div class="p-2 bg-rose-100 dark:bg-rose-900/30 rounded-lg group-hover:bg-rose-500 transition-colors duration-300">
                        <x-lucide-clock-alert class="w-5 h-5 text-rose-600 dark:text-rose-400 group-hover:text-white transition-colors" />
                    </div>
                    <span class="text-[10px] font-bold text-rose-600 dark:text-rose-400 uppercase tracking-widest">{{ __('Selesai') }}</span>
                </div>
                <h4 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">{{ number_format($stats['expired']) }}</h4>
                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-0.5">{{ __('Batas Waktu Berakhir') }}</p>
            </div>
        </div>

        {{-- ── VISITOR ANALYTICS ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

            {{-- Chart --}}
            <div class="lg:col-span-8 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md p-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-violet-100 dark:bg-violet-900/30 rounded-lg">
                            <x-lucide-bar-chart-2 class="w-4 h-4 text-violet-600 dark:text-violet-400" />
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-slate-900 dark:text-white">{{ __('Tren Kunjungan') }}</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ __('Pageview & visitor harian') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 bg-slate-100 dark:bg-slate-800 p-0.5 rounded-lg">
                        @foreach([7, 30, 90] as $days)
                            <button
                                wire:click="$set('chartDays', {{ $days }})"
                                :class="{{ $chartDays }} === {{ $days }} ? 'bg-white dark:bg-slate-700 shadow-sm text-violet-600 dark:text-white' : 'text-slate-500 dark:text-slate-400 hover:text-violet-600'"
                                class="px-3 py-1 text-[11px] font-bold rounded-md transition-all duration-200">
                                {{ $days }}d
                            </button>
                        @endforeach
                    </div>
                </div>

                <div wire:key="chart-{{ $chartDays }}">
                    <x-core::chart
                        type="line"
                        :labels="$visitorChart['labels']"
                        :datasets="[
                            [
                                'label' => 'Pageviews',
                                'data' => $visitorChart['pageviews'],
                                'borderColor' => '#8b5cf6',
                                'backgroundColor' => 'rgba(139,92,246,0.12)',
                                'borderWidth' => 2,
                                'pointRadius' => 0,
                                'pointHoverRadius' => 4,
                                'fill' => true,
                                'tension' => 0.4,
                            ],
                            [
                                'label' => 'Visitors',
                                'data' => $visitorChart['visitors'],
                                'borderColor' => '#38bdf8',
                                'backgroundColor' => 'rgba(56,189,248,0.10)',
                                'borderWidth' => 2,
                                'pointRadius' => 0,
                                'pointHoverRadius' => 4,
                                'fill' => true,
                                'tension' => 0.4,
                            ],
                        ]"
                        :options="[
                            'interaction' => ['mode' => 'index', 'intersect' => false],
                            'plugins' => ['legend' => ['display' => false]],
                            'scales' => [
                                'x' => ['ticks' => ['maxTicksLimit' => 8, 'font' => ['size' => 10]]],
                                'y' => ['beginAtZero' => true, 'ticks' => ['font' => ['size' => 10], 'precision' => 0]],
                            ],
                        ]"
                    />
                </div>
            </div>

            {{-- Key Metrics + Top Loker --}}
            <div class="lg:col-span-4 space-y-4">
                {{-- Metrics --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative group overflow-hidden p-4 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md">
                        <div class="absolute -right-3 -top-3 w-14 h-14 bg-violet-50 dark:bg-violet-900/10 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-500"></div>
                        <div class="relative">
                            <div class="p-2 bg-violet-100 dark:bg-violet-900/30 rounded-lg w-fit mb-2 group-hover:bg-violet-600 transition-colors duration-300">
                                <x-lucide-eye class="w-4 h-4 text-violet-600 dark:text-violet-400 group-hover:text-white transition-colors" />
                            </div>
                            <h4 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">
                                {{ number_format($visitorAggregate->total_pageviews ?? 0) }}
                            </h4>
                            <p class="text-[11px] font-medium text-slate-500 dark:text-slate-400">{{ __('Pageview') }}</p>
                        </div>
                    </div>

                    <div class="relative group overflow-hidden p-4 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md">
                        <div class="absolute -right-3 -top-3 w-14 h-14 bg-sky-50 dark:bg-sky-900/10 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-500"></div>
                        <div class="relative">
                            <div class="p-2 bg-sky-100 dark:bg-sky-900/30 rounded-lg w-fit mb-2 group-hover:bg-sky-600 transition-colors duration-300">
                                <x-lucide-users class="w-4 h-4 text-sky-600 dark:text-sky-400 group-hover:text-white transition-colors" />
                            </div>
                            <h4 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">
                                {{ number_format($visitorAggregate->total_visitors ?? 0) }}
                            </h4>
                            <p class="text-[11px] font-medium text-slate-500 dark:text-slate-400">{{ __('Pengunjung Unik') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Top Loker --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md p-4 flex-1">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-black text-slate-900 dark:text-white">{{ __('Top Loker') }}</h4>
                        <x-lucide-trophy class="w-4 h-4 text-amber-400" />
                    </div>

                    @if($topLokerByViews->isEmpty())
                        <div class="flex flex-col items-center justify-center py-6 text-slate-400">
                            <x-lucide-bar-chart class="w-8 h-8 mb-2 opacity-30" />
                            <p class="text-xs italic">{{ __('Belum ada data.') }}</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($topLokerByViews as $index => $item)
                                @php
                                    $maxViews = $topLokerByViews->max('total_pageviews') ?: 1;
                                    $pct      = round(($item->total_pageviews / $maxViews) * 100);
                                    $colors   = ['bg-violet-500','bg-sky-500','bg-emerald-500','bg-amber-500','bg-rose-500'];
                                    $color    = $colors[$index % 5];
                                @endphp
                                <div class="group">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <span class="shrink-0 w-4 h-4 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center text-[9px] font-black text-slate-500">
                                                {{ $index + 1 }}
                                            </span>
                                            <div class="min-w-0">
                                                <p class="text-xs font-bold text-slate-800 dark:text-slate-200 truncate group-hover:text-violet-600 transition-colors">
                                                    {{ $item->nama_pekerjaan }}
                                                </p>
                                                <p class="text-[10px] text-slate-400 truncate">{{ $item->nama_perusahaan }}</p>
                                            </div>
                                        </div>
                                        <div class="shrink-0 ml-2 text-right">
                                            <p class="text-xs font-black text-slate-700 dark:text-slate-300">{{ number_format($item->total_pageviews) }}</p>
                                            <p class="text-[9px] text-slate-400">{{ number_format($item->total_visitors) }} unik</p>
                                        </div>
                                    </div>
                                    <div class="h-1 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                        <div class="h-full {{ $color }} rounded-full transition-all duration-1000" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── BOTTOM ROW: Distribusi + Perusahaan + Aktivitas ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

            {{-- Distribusi --}}
            <div class="lg:col-span-5 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md p-5" x-data="{ activeTab: 'category' }">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-sm font-black text-slate-900 dark:text-white">{{ __('Distribusi') }}</h4>
                    <div class="flex bg-slate-100 dark:bg-slate-800 p-0.5 rounded-lg">
                        <button @click="activeTab = 'category'"
                            :class="activeTab === 'category' ? 'bg-white dark:bg-slate-700 shadow-sm text-indigo-600 dark:text-white' : 'text-slate-500 dark:text-slate-400'"
                            class="px-3 py-1 text-[10px] font-bold rounded-md transition-all duration-200">
                            {{ __('Kategori') }}
                        </button>
                        <button @click="activeTab = 'type'"
                            :class="activeTab === 'type' ? 'bg-white dark:bg-slate-700 shadow-sm text-emerald-600 dark:text-white' : 'text-slate-500 dark:text-slate-400'"
                            class="px-3 py-1 text-[10px] font-bold rounded-md transition-all duration-200">
                            {{ __('Tipe') }}
                        </button>
                    </div>
                </div>

                <div class="relative min-h-[200px]">
                    {{-- By Category --}}
                    <div x-show="activeTab === 'category'" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0" class="space-y-3">
                        @forelse($byCategory->take(8) as $cat)
                            <div class="group">
                                <div class="flex justify-between items-end mb-1">
                                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300 group-hover:text-indigo-600 transition-colors">{{ $cat->kategory ?: __('Umum') }}</span>
                                    <span class="text-[10px] font-black text-slate-400">{{ $cat->total }}</span>
                                </div>
                                <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-500 rounded-full group-hover:bg-indigo-600 transition-all duration-1000"
                                        style="width: {{ ($cat->total / max(1, $stats['total'])) * 100 }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic">{{ __('Belum ada data.') }}</p>
                        @endforelse
                    </div>

                    {{-- By Type --}}
                    <div x-show="activeTab === 'type'" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="space-y-3">
                        @forelse($byType->take(8) as $type)
                            <div class="group">
                                <div class="flex justify-between items-end mb-1">
                                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300 group-hover:text-emerald-600 transition-colors">{{ $type->tipe ?: __('Lainnya') }}</span>
                                    <span class="text-[10px] font-black text-slate-400">{{ $type->total }}</span>
                                </div>
                                <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full group-hover:bg-emerald-600 transition-all duration-1000"
                                        style="width: {{ ($type->total / max(1, $stats['total'])) * 100 }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic">{{ __('Belum ada data.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Top Perusahaan --}}
            <div class="lg:col-span-4 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-md p-5">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-sm font-black text-slate-900 dark:text-white">{{ __('Top Mitra') }}</h4>
                    <x-core::secondary-button link href="{{ route('loker.company.index') }}" label="{{ __('Semua') }}" size="sm" />
                </div>

                <div class="space-y-3">
                    @foreach($topCompanies as $company)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50 group hover:bg-white dark:hover:bg-slate-800 hover:shadow-md transition-all duration-300">
                            <div class="w-9 h-9 rounded-full bg-white dark:bg-slate-700 shadow-sm flex items-center justify-center shrink-0 ring-2 ring-indigo-50 dark:ring-indigo-900/20 group-hover:scale-105 transition-transform">
                                <x-lucide-building-2 class="w-4 h-4 text-indigo-500" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $company->nama_perusahaan }}</p>
                                <p class="text-[10px] text-slate-400">{{ $company->total }} {{ __('Lowongan') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Aktivitas Terbaru --}}
            <div class="lg:col-span-3 bg-indigo-600 dark:bg-indigo-700 rounded-2xl shadow-xl shadow-indigo-200 dark:shadow-none p-5 text-white relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute -left-8 -top-8 w-32 h-32 bg-indigo-400/20 rounded-full blur-2xl"></div>

                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-black tracking-tight">{{ __('Terbaru') }}</h4>
                        <div class="p-1.5 bg-white/20 rounded-lg backdrop-blur-md">
                            <x-lucide-history class="w-3.5 h-3.5 text-white" />
                        </div>
                    </div>

                    <div class="space-y-3">
                        @foreach($latestLokers as $loker)
                            <div class="flex gap-3 group">
                                <div class="flex flex-col items-center gap-1.5">
                                    <div class="w-1.5 h-1.5 rounded-full bg-white group-hover:scale-150 transition-transform shadow-[0_0_6px_rgba(255,255,255,0.8)]"></div>
                                    @if(!$loop->last)
                                        <div class="w-px h-8 bg-white/20"></div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10 group-hover:bg-white/20 transition-all duration-300">
                                        <h6 class="text-xs font-bold leading-tight line-clamp-1">{{ $loker->nama_pekerjaan }}</h6>
                                        <p class="text-[10px] text-indigo-100 mt-0.5 opacity-80 truncate">{{ $loker->nama_perusahaan }}</p>
                                        <div class="flex items-center justify-between mt-2">
                                            <span class="text-[9px] px-1.5 py-0.5 bg-white/20 rounded-md font-bold">{{ $loker->tipe ?: 'N/A' }}</span>
                                            <span class="text-[9px] opacity-60 italic">{{ $loker->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <x-core::button link href="{{ route('loker.loker.index') }}" variant="white" full
                            class="!rounded-xl !py-2.5 text-xs shadow-lg shadow-indigo-800/20"
                            label="{{ __('Buka Manajemen') }}">
                            <x-slot name="icon"><x-lucide-arrow-right class="w-3.5 h-3.5" /></x-slot>
                        </x-core::button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── MASTER DATA ── --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="{{ route('loker.category.index') }}"
                class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 shadow-md flex flex-col items-center justify-center gap-2 group hover:border-indigo-300 dark:hover:border-indigo-700 hover:shadow-lg transition-all duration-300">
                <x-lucide-tag class="w-5 h-5 text-indigo-500 group-hover:scale-110 transition-transform" />
                <span class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ __('Kategori') }}</span>
                <span class="text-[10px] px-2 py-0.5 bg-indigo-50 dark:bg-indigo-900/30 rounded-full text-indigo-600 dark:text-indigo-400 font-bold">{{ $stats['total_categories'] }}</span>
            </a>
            <a href="{{ route('loker.type.index') }}"
                class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 shadow-md flex flex-col items-center justify-center gap-2 group hover:border-emerald-300 dark:hover:border-emerald-700 hover:shadow-lg transition-all duration-300">
                <x-lucide-layers class="w-5 h-5 text-emerald-500 group-hover:scale-110 transition-transform" />
                <span class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ __('Tipe') }}</span>
                <span class="text-[10px] px-2 py-0.5 bg-emerald-50 dark:bg-emerald-900/30 rounded-full text-emerald-600 dark:text-emerald-400 font-bold">{{ $stats['total_types'] }}</span>
            </a>
        </div>

    </div>
</div>
