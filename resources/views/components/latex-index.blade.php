<x-filament::section class="w-full rounded-l-none">
    <x-slot name="heading">Filament Latex</x-slot>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.9.155/pdf_viewer.min.css"
    />
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
            x-ignore
            ax-load
            x-model="message"
            ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-latex', 'thethunderturner/filament-latex') }}"
            x-data="codeEditor({
                        content: @js($latexContent),
                    })"
            wire:ignore
        ></div>

        {{-- PDF Preview --}}
        <div
            class="h-screen overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700"
            x-ignore
            ax-load
            ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-latex', 'thethunderturner/filament-latex') }}"
            x-data="pdfViewer({
                        content: @js($pdfUrl),
                        pagination: true,
                    })"
            wire:ignore
        >
            @if ($pdfUrl)
                {{-- The viewer will create its own canvas elements --}}
            @else
                <p class="p-4">No PDF available to preview.</p>
            @endif
        </div>
    </div>
</x-filament::section>
