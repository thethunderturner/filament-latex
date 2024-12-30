<div class="flex items-center justify-between rounded-md border bg-white p-2 shadow-sm dark:bg-gray-800">
    <span class="truncate text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ $file }}
    </span>
    <div>
        {{ ($this->deleteAction)(['file' => $file]) }}

        <x-filament-actions::modals />
    </div>
</div>
