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
            <script type="module">
                import { LaTeXJSComponent } from "https://cdn.jsdelivr.net/npm/latex.js/dist/latex.mjs"
                customElements.define("latex-js", LaTeXJSComponent)
            </script>

            <div
                class="grid grid-cols-2 gap-4"
                x-data="{ message: '' }"
                x-init="$watch('message', value => {
                const container = $refs.latexContainer;
                container.innerHTML = '';
                const latex = document.createElement('latex-js');
                latex.textContent = value;
                container.appendChild(latex);

                // Sync with Livewire component
                @this.latexContent = value;
            })"
            >
                {{-- Latex Editor --}}
                <div
                    class="w-full border border-gray-200 rounded-lg dark:border-gray-700"
                    x-model="message"
                    x-ignore
                    ax-load
                    ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-latex', 'thethunderturner/filament-latex') }}"
                    x-data="codeEditor()"
                >
                </div>

                {{-- Latex Preview --}}
                <div
                    class="border border-gray-200 rounded-lg dark:border-gray-700"
                    x-ref="latexContainer"
                >

                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
