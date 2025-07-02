@php
    $latexContent = $this->latexContent;
    $pdfUrl = $this->getPdfUrl();
    $files = $this->getFiles();
@endphp

<x-filament-panels::page>
    <div x-data="{ isFileUploadVisible: true }" class="inline-flex w-full justify-stretch rounded-md" role="group">
        {{-- File Upload Container --}}
        <div x-show="isFileUploadVisible">
            @include('filament-latex::components.file-upload-index', ['files' => $files])
        </div>

        {{-- Latex Container --}}
        @include('filament-latex::components.latex-index', [
            'latexContent' => $latexContent,
            'pdfUrl' => $pdfUrl,
            'isFileUploadVisible' => true
        ])
    </div>
</x-filament-panels::page>
