<div class="p-2 border rounded-md bg-white dark:bg-gray-800 flex items-center justify-between shadow-sm">
    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate">
        {{ $file }}
    </span>
    <div>
        {{ ($this->deleteAction)(['file' => $file]) }}

        <x-filament-actions::modals />
    </div>
</div>
