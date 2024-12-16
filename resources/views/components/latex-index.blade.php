<x-filament::section class="w-full rounded-l-none">
    <x-slot name="heading">Filament Latex</x-slot>
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
        <div class="rounded-lg border border-gray-200 dark:border-gray-700">
            @if ($pdfUrl)
                <iframe
                    x-data="{ pdfUrl: @js($pdfUrl) }"
                    x-on:document-compiled.window="pdfUrl"
                    class="h-screen w-full"
                    :src="pdfUrl"
                ></iframe>
            @else
                <p>No PDF available to preview.</p>
            @endif
        </div>
    </div>
</x-filament::section>
