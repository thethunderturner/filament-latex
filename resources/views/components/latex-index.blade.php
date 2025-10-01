@php
    $pdfJS = $this->usePdfJs();
    $paginate = $this->paginate();
    $autocompileDelay = $this->autocompileDelay();
    $autocompile = $this->autocompile();
    $isFileUploadCollapsed = $this->isFileUploadCollapsed;
@endphp

<x-filament::section
    class="w-full"
    x-bind:class="{ 'rounded-lg': !isFileUploadCollapsed, 'rounded-l-none': isFileUploadCollapsed }"
>
    <x-slot name="heading">
        <button type="button" @click="isFileUploadCollapsed = !isFileUploadCollapsed">
            <x-heroicon-o-arrow-left x-show="isFileUploadCollapsed" class="mr-4 h-4 w-4 text-gray-500" />
            <x-heroicon-o-arrow-right x-show="!isFileUploadCollapsed" class="mr-4 h-4 w-4 text-gray-500" />
        </button>
        Filament Latex
    </x-slot>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/5.3.31/pdf_viewer.min.css" />
    <div
        class="grid grid-cols-2 gap-4"
        x-data="{ message: '' }"
        x-init="
            $watch('message', (value) => {
                // Sync with Livewire component
                @this.latexContent = value
            })
        "
    >
        {{-- Latex Editor --}}
        <div
            class="h-screen w-full overflow-auto rounded-lg border border-gray-200 dark:border-gray-700"
            x-load
            x-model="message"
            x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-latex', 'thethunderturner/filament-latex') }}"
            x-data="codeEditor({
                        content: @js($latexContent),
                        autocompile: @js($autocompile),
                        autocompileDelay: @js($autocompileDelay),
                    })"
            wire:ignore
        ></div>

        {{-- PDF Preview --}}
        @if ($pdfJS)
            {{-- Use PDF.js --}}
            <div
                class="h-screen overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700"
                x-load
                x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-latex', 'thethunderturner/filament-latex') }}"
                x-data="pdfViewer({
                            content: @js($pdfUrl),
                            pagination: @js($paginate),
                        })"
                wire:ignore
            >
                @if ($pdfUrl)
                    {{-- The viewer will create its own canvas elements --}}
                @else
                    <p class="p-4">No PDF available to preview.</p>
                @endif
            </div>
        @else
            {{-- Use browser defaullt PDF viewer --}}
            <div class="rounded-lg border border-gray-200 dark:border-gray-700">
                @if ($pdfUrl)
                    <iframe
                        x-data="{ pdfUrl: @js($pdfUrl) }"
                        {{-- '?' + new Date().getTime() is a hack that allows for refresh upon compilation --}}
                        {{-- New timestamp forces broswer to listen to new query, bypassing caching issues (Unsure if there is a better way). --}}
                        x-on:document-compiled.window="pdfUrl = @js($pdfUrl) + '?' + new Date().getTime()"
                        class="h-screen w-full"
                        src="pdfUrl"
                    ></iframe>
                @else
                    <p>No PDF available to preview.</p>
                @endif
            </div>
        @endif
    </div>
</x-filament::section>
