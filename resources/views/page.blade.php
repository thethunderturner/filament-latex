<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">CodeMirror Integration</x-slot>

        <div class="grid grid-flow-col justify-stretch gap-4">
            <div
                id="codemirror-container"
                x-ignore
                ax-load
                ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-latex', 'thethunderturner/filament-latex') }}"
                x-data="codeEditor()"
            >

            </div>

            <div class="border rounded p-4">02</div>
        </div>
    </x-filament::section>
</x-filament-panels::page>
