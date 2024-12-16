@php
    $latexContent = $this->latexContent;
    $pdfUrl = $this->getPdfUrl();
    $files = $this->getFiles();
@endphp

<x-filament-panels::page>
    <div class="inline-flex w-full justify-stretch rounded-md" role="group">
        {{-- File Upload Container --}}
        @include('filament-latex::components.file-upload-index', ['files' => $files])

        {{-- Latex Container --}}
        @include('filament-latex::components.latex-index', ['latexContent' => $latexContent, 'pdfUrl' => $pdfUrl])
    </div>
</x-filament-panels::page>
