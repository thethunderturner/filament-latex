<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use TheThunderTurner\FilamentLatex\Concerns\CanUploadFiles;
use TheThunderTurner\FilamentLatex\Concerns\CanUseDocument;
use TheThunderTurner\FilamentLatex\Models\FilamentLatex;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource;

class ViewFilamentLatex extends Page implements HasActions, HasForms
{
    use CanUploadFiles;
    use CanUseDocument;
    use InteractsWithActions;
    use InteractsWithForms;

    protected static string $resource = FilamentLatexResource::class;

    public FilamentLatex $filamentLatex;

    public string $latexContent = '';

    public function mount(int | string $record): void
    {
        $this->filamentLatex = FilamentLatex::findOrFail($record);
        $this->latexContent = $this->filamentLatex->content;
    }

    protected static string $view = 'filament-latex::page';

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('downloadAction')
                ->hiddenLabel()
                ->color('info')
                ->extraAttributes([
                    'class' => 'rounded-r-none -mr-3',
                ])
                ->tooltip('Download PDF')
                ->icon('heroicon-o-document-arrow-down')
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
