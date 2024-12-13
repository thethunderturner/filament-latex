<div class="p-2 border rounded-md bg-white dark:bg-gray-800 flex items-center justify-between shadow-sm">
    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate">
        {{ $file }}
    </span>
    <button
        type="button"
        class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-600 transition"
        title="Delete file"
    >
        <x-heroicon-o-trash class="h-5 w-5" />
    </button>
</div>
