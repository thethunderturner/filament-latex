@php
    $latexContent = $this->latexContent;
    $pdfUrl = $this->getPdfUrl();
    $files = $this->getFiles();
@endphp

<x-filament-panels::page>
    <div x-data="{ isFileUploadCollapsed: true }" class="inline-flex w-full justify-stretch" role="group">
        {{-- File Upload Container --}}
        <div x-show="isFileUploadCollapsed">
            @include('filament-latex::components.file-upload-index', ['files' => $files])
        </div>

        {{-- Latex Container --}}
        @include(
            'filament-latex::components.latex-index',
            [
                'latexContent' => $latexContent,
                'pdfUrl' => $pdfUrl,
                'isFileUploadCollapsed' => true,
            ]
        )
    </div>
</x-filament-panels::page>
