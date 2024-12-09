<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages;

use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource;

class ViewFilamentLatex extends Page
{
    use InteractsWithRecord;

    protected static string $resource = FilamentLatexResource::class;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->latexContent = $this->record->content;
    }

    protected static string $view = 'filament-latex::page';

    public string $latexContent = '';

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('downloadAction')
                ->label('Download PDF')
                ->color('info')
                ->extraAttributes([
                    'class' => 'rounded-l-lg',
                ])
                ->action(function () {
                    //                    return response()->streamDownload(function () {
                    //                        echo Pdf::loadHtml(
                    //                            Blade::render('filament-latex::latex-pdf')
                    //                        )->stream();
                    //                    }, 'test.pdf');
                    //                    $this->downloadDocument($this->latexContent);
                }),
            Action::make('compileAction')
                ->label('Compile')
                ->color('success')
                ->action(function () {
                    $this->compileDocument();
                    //                    return response()->streamDownload(function () {
                    //                        echo Pdf::loadHtml(
                    //                            Blade::render('filament-latex::latex-pdf')
                    //                        )->stream();
                    //                    }, 'test.pdf');
                    //                    $this->generateAndDownloadPDF($this->latexContent);
                }),
        ];
    }

    /**
     * Generate and download a PDF of the document.
     */
    protected function downloadDocument(): void
    {
        // Get the file from storage, and then use pdf latex binary to generate the pdf.

    }

    /**
     * Compile the document.
     *
     * STRATEGY:
     * When compiles, we create a .tex file at the
     * /storage/storage_name/filament-latex/{record-id} directory.
     *
     * Then we use the pdflatex binary command to compile the .tex file.
     * and we store the .pdf file at the same directory, or we find a way to stream
     * it to the preview div.
     *
     * If the user presses download, then we compile, generate the pdf and download it.
     */
    protected function compileDocument(): void
    {
        Storage::disk(config('filament-latex.storage.disk'))->put($this->record->id . '/main.tex', $this->latexContent);
        // ...
    }
}
