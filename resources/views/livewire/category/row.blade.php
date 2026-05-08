<tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
    <td class="px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                <x-lucide-tag class="w-5 h-5 text-purple-600 dark:text-purple-400" />
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $record->name }}</p>
                <p class="text-[10px] text-gray-500 uppercase tracking-widest">{{ $record->slug }}</p>
            </div>
        </div>
    </td>
    <td class="px-6 py-4">
        @if($record->actived)
            <span
                class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                {{ __('Aktif') }}
            </span>
        @else
            <span
                class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400">
                <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>
                {{ __('Non-aktif') }}
            </span>
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap w-px">
        @canany(['loker.category.update', 'loker.category.delete'])
            <livewire:core.shared-components.item-actions :editUrl="route('loker.category.edit', $record->id)"
                :deleteId="$record->id" :navigate="true" wire:key="category-actions-{{ $record->id }}"
                confirmMessage="{{ __('Yakin ingin menghapus kategori ini?') }}" />
        @endcanany
    </td>
</tr>