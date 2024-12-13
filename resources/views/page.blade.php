@php
    $latexContent = $this->latexContent;
    $pdfUrl = $this->getPdfUrl();
    $files = $this->getFiles();
@endphp

<x-filament-panels::page>
    <div class="inline-flex w-full justify-stretch rounded-md" role="group">

        {{-- File Upload Container --}}
        <x-filament::section class="w-64 rounded-r-none">
            <x-slot name="heading">File Upload</x-slot>

            {{-- Upload Action --}}
            <div>
                {{ $this->uploadAction }}

                <x-filament-actions::modals />
            </div>

            <div class="mt-6 border-t border-gray-200 dark:border-white/10 h-[79rem] overflow-auto space-y-2">
                @forelse($files as $file)
                    @include('filament-latex::components.file-upload', ['file' => $file])
                @empty
                    <div class="text-gray-500 dark:text-gray-400 text-center">
                        No files uploaded.
                    </div>
                @endforelse
            </div>
        </x-filament::section>

        {{-- Latex Container --}}
        <x-filament::section class="w-full rounded-l-none">
            <x-slot name="heading">Filament Latex</x-slot>
            <div
                class="grid grid-cols-2 gap-4"
                x-data="{ message: '' }"
                x-init="$watch('message', value => {
                    // Sync with Livewire component
                    @this.latexContent = value;
                })"
            >
                {{-- Latex Editor --}}
                <div
                    class="w-full border border-gray-200 rounded-lg dark:border-gray-700 h-screen overflow-auto"
                    x-ignore
                    ax-load
                    x-model="message"
                    ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-latex', 'thethunderturner/filament-latex') }}"
                    x-data="codeEditor({
                        content: @js($latexContent),
                    })"
                    wire:ignore
                >
                </div>

                {{-- PDF Preview --}}
                <div
                    class="border border-gray-200 rounded-lg dark:border-gray-700"
                >
                    @if($pdfUrl)
                        <iframe
                            x-data="{ pdfUrl: @js($pdfUrl) }"
                            x-on:document-compiled.window="pdfUrl = @js($pdfUrl) + '?' + new Date().getTime()"
                            class="w-full h-screen"
                            :src="pdfUrl"
                        >
                        </iframe>
                    @else
                        <p>No PDF available to preview.</p>
                    @endif
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
