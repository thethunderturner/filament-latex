<x-filament::section class="w-64 rounded-r-none">
    <x-slot name="heading">File Upload</x-slot>

    {{-- Upload Action --}}
    <div>
        {{ $this->uploadAction }}

        <x-filament-actions::modals />
    </div>

    <div class="mt-6 h-[79rem] overflow-auto space-y-2">
        @forelse ($files as $file)
            @include('filament-latex::components.file-upload', ['file' => $file])
        @empty
            <div class="text-gray-500 dark:text-gray-400 text-center">
                No files uploaded.
            </div>
        @endforelse
    </div>
</x-filament::section>
