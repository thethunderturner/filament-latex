<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\Support\Htmlable;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\FilamentLatexResource;

class ViewFilamentLatex extends Page
{
    use InteractsWithRecord;

    protected static string $resource = FilamentLatexResource::class;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

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
