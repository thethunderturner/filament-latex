<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Filament Latex</x-slot>
        <script type="module">
            import { LaTeXJSComponent } from "https://cdn.jsdelivr.net/npm/latex.js/dist/latex.mjs"
            customElements.define("latex-js", LaTeXJSComponent)
        </script>
        <div class="grid grid-flow-col justify-stretch gap-4">
            <div
                id="codemirror-container"
                x-ignore
                ax-load
                ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-latex', 'thethunderturner/filament-latex') }}"
                x-data="codeEditor()"
            >
            </div>

{{--            pu ax-load here, and call the render function--}}
            <latex-js
                id="latex-preview"
                class="border"
            >
                \documentclass{article}

                \begin{document}
                lorem ipsum dolor whatever
                \end{document}
            </latex-js>
        </div>
    </x-filament::section>
</x-filament-panels::page>
