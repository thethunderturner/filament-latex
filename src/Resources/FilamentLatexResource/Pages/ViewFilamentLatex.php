<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages;

use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Blade;
use TheThunderTurner\FilamentLatex\Concerns\CanUseDocument;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource;

class ViewFilamentLatex extends Page
{
    use CanUseDocument;
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
                    'class' => 'rounded-r-none -mr-3',
                ])
                ->tooltip('Download PDF')
                ->action(function () {
                    return $this->downloadDocument();
                }),
            Action::make('compileAction')
                ->label('Compile')
                ->color('success')
                ->extraAttributes([
                    'class' => 'rounded-l-none',
                ])
                ->action(function () {
                    $this->compileDocument();
                }),
        ];
    }
}
