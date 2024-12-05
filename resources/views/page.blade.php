<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Filament Latex</x-slot>
        <script type="module">
            import { LaTeXJSComponent } from "https://cdn.jsdelivr.net/npm/latex.js/dist/latex.mjs"
            customElements.define("latex-js", LaTeXJSComponent)
        </script>
        <div
            x-data="{ message: '' }"
            x-init="$watch('message', value => {
                const container = $refs.latexContainer;
                container.innerHTML = '';
                const latex = document.createElement('latex-js');
                latex.textContent = value;
                container.appendChild(latex);
            })"
        >
            <textarea
                type="text"
                x-model="message"
                class="w-full p-2 mb-4 border rounded"
                rows="5"
            ></textarea>

            <div x-ref="latexContainer"></div>
        </div>
    </x-filament::section>
</x-filament-panels::page>
