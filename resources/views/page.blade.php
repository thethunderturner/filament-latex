@php
$latexContent = $this->latexContent;
@endphp

<x-filament-panels::page>
    <div class="inline-flex w-full justify-stretch rounded-md" role="group">

        {{-- File Upload Container --}}
        <x-filament::section class="w-64 rounded-r-none">
            <x-slot name="heading">File Upload</x-slot>

            TBA
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
                    class="w-full border border-gray-200 rounded-lg dark:border-gray-700"
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

                {{-- Latex Preview --}}
                <div
                    class="border border-gray-200 rounded-lg dark:border-gray-700">
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
