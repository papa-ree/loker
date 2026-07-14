<tr wire:key="loker-row-{{ $record->id }}"
    class="hover:bg-gray-50/80 dark:hover:bg-gray-800/50 transition-colors duration-150">

    {{-- Pekerjaan --}}
    <td class="px-4 py-3.5 w-full max-w-0 sm:max-w-none sm:w-auto">
        <div class="flex items-center gap-3">
            <div class="size-10 rounded-xl bg-linear-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/30 flex items-center justify-center shrink-0 border border-indigo-200/50 dark:border-indigo-700/30">
                <x-lucide-briefcase class="size-5 text-indigo-600 dark:text-indigo-400" />
            </div>
            <div class="min-w-0 flex-1">
                <span class="block text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">
                    {{ $record->nama_pekerjaan }}
                </span>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        {{ $record->nama_perusahaan }}
                    </span>
                    <span class="text-gray-300 dark:text-gray-600">•</span>
                    <span class="text-[10px] font-medium px-1.5 py-0.5 rounded-md bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                        {{ $record->tipe }}
                    </span>
                </div>
            </div>
        </div>
    </td>

    {{-- Kategori --}}
    <td class="px-4 py-3.5 text-sm text-gray-600 dark:text-gray-300">
        @if($record->kategory)
            <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800/30">
                {{ $record->kategory }}
            </span>
        @else
            <span class="text-xs text-gray-400 italic">—</span>
        @endif
    </td>

    {{-- Lokasi --}}
    <td class="px-4 py-3.5 text-sm text-gray-600 dark:text-gray-300">
        <div class="flex items-center gap-1.5">
            <x-lucide-map-pin class="size-3.5 text-gray-400" />
            <span>{{ $record->lokasi }}</span>
        </div>
    </td>

    {{-- Gaji --}}
    <td class="px-4 py-3.5 text-sm whitespace-nowrap">
        @if($record->gaji)
            <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800/30 px-2 py-1 rounded-lg">
                <x-lucide-dollar-sign class="size-3" />
                {{ $record->gaji }}
            </span>
        @else
            <span class="text-xs text-gray-400 italic">—</span>
        @endif
    </td>

    {{-- Masa Berlaku --}}
    <td class="px-4 py-3.5">
        @if($record->tgl_berakhir)
            <div class="flex flex-col">
                <span class="text-sm font-medium {{ $record->is_expired ? 'text-rose-600 dark:text-rose-400' : 'text-gray-700 dark:text-gray-300' }}">
                    {{ $record->tgl_berakhir->format('d M Y') }}
                </span>
                <span class="text-[10px] uppercase font-bold tracking-widest {{ $record->is_expired ? 'text-rose-400' : 'text-gray-400' }}">
                    {{ $record->is_expired ? __('EXPIRED') : __('Hingga') }}
                </span>
            </div>
        @else
            <span class="text-gray-400 italic text-xs">{{ __('Tanpa batas') }}</span>
        @endif
    </td>

    {{-- Pengunjung --}}
    @php
        $sumPageviews = $record->visitors ? $record->visitors->sum('pageviews') : 0;
        $sumVisitors  = $record->visitors ? $record->visitors->sum('visitors') : 0;
    @endphp
    <td class="px-4 py-3.5 text-sm whitespace-nowrap">
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1 text-xs font-semibold text-slate-750 dark:text-slate-300 bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700/50 px-2.5 py-1 rounded-lg" title="{{ __('Pageviews (Total Kunjungan Halaman)') }}">
                <x-lucide-eye class="size-3.5 text-violet-500" />
                {{ number_format($sumPageviews) }}
            </span>
            <span class="inline-flex items-center gap-1 text-xs font-semibold text-slate-750 dark:text-slate-300 bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700/50 px-2.5 py-1 rounded-lg" title="{{ __('Unique Visitors (Pengunjung Individu)') }}">
                <x-lucide-users class="size-3.5 text-sky-500" />
                {{ number_format($sumVisitors) }}
            </span>
        </div>
    </td>

    {{-- Status --}}
    <td class="px-4 py-3.5">
        @if($record->is_expired)
            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20 dark:bg-rose-900/30 dark:text-rose-400">
                <span class="size-1.5 rounded-full bg-rose-500"></span>
                {{ __('Kadaluarsa') }}
            </span>
        @elseif($record->actived)
            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-50 text-teal-700 ring-1 ring-inset ring-teal-600/20 dark:bg-teal-900/30 dark:text-teal-400">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                </span>
                {{ __('Aktif') }}
            </span>
        @else
            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-50 text-gray-600 ring-1 ring-inset ring-gray-500/20 dark:bg-gray-800/50 dark:text-gray-400">
                <span class="size-1.5 rounded-full bg-gray-400"></span>
                {{ __('Non-aktif') }}
            </span>
        @endif
    </td>

    {{-- Actions --}}
    <td class="px-4 py-3.5 whitespace-nowrap w-px">
        @canany(['loker.update', 'loker.delete'])
            <livewire:core.shared-components.item-actions
                :editUrl="route('loker.loker.edit', $record->id)"
                :deleteId="$record->id"
                :navigate="true"
                confirmMessage="{{ __('Yakin ingin menghapus lowongan ini?') }}"
                wire:key="item-actions-{{ $record->id }}" />
        @endcanany
    </td>
</tr>
