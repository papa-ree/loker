<tr wire:key="category-row-{{ $record->id }}"
    class="hover:bg-gray-50/80 dark:hover:bg-gray-800/50 transition-colors duration-150">

    {{-- Icon & Name --}}
    <td class="px-4 py-3.5 w-full max-w-0 sm:max-w-none sm:w-auto">
        <div class="flex items-center gap-3">
            <div class="size-9 rounded-lg bg-linear-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/30 flex items-center justify-center shrink-0 border border-purple-200/50 dark:border-purple-700/30">
                @if($record->icon)
                    <x-dynamic-component :component="'lucide-' . $record->icon" class="size-4 text-purple-600 dark:text-purple-400" />
                @else
                    <x-lucide-tag class="size-4 text-purple-600 dark:text-purple-400" />
                @endif
            </div>
            <div class="min-w-0 flex-1">
                <span class="block text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">
                    {{ $record->name }}
                </span>
                @if($record->description)
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5">
                        {{ $record->description }}
                    </p>
                @endif
            </div>
        </div>
    </td>

    {{-- Slug --}}
    <td class="px-4 py-3.5 text-xs font-mono text-gray-500 dark:text-gray-400">
        {{ $record->slug }}
    </td>

    {{-- Status --}}
    <td class="px-4 py-3.5">
        @if($record->actived)
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
        <livewire:core.shared-components.item-actions 
            :editUrl="route('loker.category.edit', $record->id)"
            :deleteId="$record->id" 
            :navigate="true" 
            confirmMessage="{{ __('Yakin ingin menghapus kategori ini?') }}"
            wire:key="item-actions-{{ $record->id }}" />
    </td>
</tr>
