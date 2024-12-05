<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Filament Latex</x-slot>
        <script type="module">
            import { LaTeXJSComponent } from "https://cdn.jsdelivr.net/npm/latex.js/dist/latex.mjs"
            customElements.define("latex-js", LaTeXJSComponent)
        </script>
        <div
            class="grid grid-flow-col justify-stretch gap-4"
            x-data="{ message: '' }"
            x-init="$watch('message', value => {
                const container = $refs.latexContainer;
                container.innerHTML = '';
                const latex = document.createElement('latex-js');
                latex.textContent = value;
                container.appendChild(latex);
            })"
        >
            <div
                x-model="message"
                x-ignore
                ax-load
                ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-latex', 'thethunderturner/filament-latex') }}"
                x-data="codeEditor()"
            >
            </div>
            <div x-ref="latexContainer"></div>
        </div>
    </x-filament::section>
</x-filament-panels::page>
