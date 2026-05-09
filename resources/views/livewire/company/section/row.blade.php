<tr wire:key="company-row-{{ $record->id }}"
    class="hover:bg-gray-50/80 dark:hover:bg-gray-800/50 transition-colors duration-150">

    {{-- Logo & Name --}}
    <td class="px-4 py-3.5 w-full max-w-0 sm:max-w-none sm:w-auto">
        <div class="flex items-center gap-3">
            <div class="size-10 rounded-xl bg-white dark:bg-gray-800 flex items-center justify-center shrink-0 border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                @if($record->logo)
                    <img src="{{ $record->logo_url }}" alt="{{ $record->name }}" class="size-full object-contain p-1">
                @else
                    <x-lucide-building-2 class="size-5 text-gray-400" />
                @endif
            </div>
            <div class="min-w-0 flex-1">
                <span class="block text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">
                    {{ $record->name }}
                </span>
                @if($record->website)
                    <a href="{{ $record->website }}" target="_blank" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1 mt-0.5">
                        <x-lucide-external-link class="size-3" />
                        {{ parse_url($record->website, PHP_URL_HOST) }}
                    </a>
                @endif
            </div>
        </div>
    </td>

    {{-- Address --}}
    <td class="px-4 py-3.5 text-sm text-gray-600 dark:text-gray-400 max-w-xs truncate">
        <div class="flex items-center gap-1.5">
            <x-lucide-map-pin class="size-3.5 text-gray-400 shrink-0" />
            <span class="truncate">{{ $record->address }}</span>
        </div>
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
            :editUrl="route('loker.company.edit', $record->id)"
            :deleteId="$record->id" 
            :navigate="true" 
            confirmMessage="{{ __('Yakin ingin menghapus perusahaan ini?') }}"
            wire:key="item-actions-{{ $record->id }}" />
    </td>
</tr>
