<tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
    <td class="px-6 py-4">
        <div class="flex flex-col">
            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $record->nama_pekerjaan }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $record->tipe }} • {{ $record->kategory }}</span>
        </div>
    </td>
    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
        {{ $record->nama_perusahaan }}
    </td>
    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
        {{ $record->lokasi }}
    </td>
    <td class="px-6 py-4">
        <div class="flex flex-col">
            @if($record->tgl_berakhir)
                <span class="text-sm {{ $record->is_expired ? 'text-rose-600 font-bold' : '' }}">
                    {{ $record->tgl_berakhir->format('d M Y') }}
                </span>
                <span class="text-[10px] uppercase tracking-tighter text-gray-400">
                    {{ $record->is_expired ? __('Sudah Berakhir') : __('Hingga') }}
                </span>
            @else
                <span class="text-gray-400 italic text-xs">{{ __('Tanpa batas') }}</span>
            @endif
        </div>
    </td>
    <td class="px-6 py-4">
        @if($record->is_expired)
            <span
                class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400">
                Expired
            </span>
        @elseif($record->actived)
            <span
                class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-800/30 dark:text-emerald-400">
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                Aktif
            </span>
        @else
            <span
                class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400">
                Non-aktif
            </span>
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap w-px">
        @canany(['loker.update', 'loker.delete'])
            <livewire:core.shared-components.item-actions :editUrl="route('loker.loker.edit', $record->id)"
                :deleteId="$record->id" :navigate="true" wire:key="loker-actions-{{ $record->id }}"
                confirmMessage="{{ __('Apakah Anda yakin ingin menghapus lowongan ini?') }}" />
        @endcanany
    </td>
</tr>