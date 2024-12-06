<?php

namespace TheThunderTurner\FilamentLatex;

use Abiturma\LaravelLatex\Facades\Latex;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\Support\Htmlable;
use PhpLatex_PdfLatex;

class FilamentLatex extends Page
{
    protected static string $view = 'filament-latex::page';

    public string $latexContent = '';

    public static function getNavigationIcon(): string | Htmlable | null
    {
        return view('filament-latex::svg.latex');
    }

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
                ->action(function () {
                    $this->generateAndDownloadPDF($this->latexContent);
                }),
        ];
    }

    protected function generateAndDownloadPDF(string $content): void
    {
        // ...
    }
}
