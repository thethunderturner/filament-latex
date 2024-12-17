<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\Support\Htmlable;
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

    protected static string $view = 'filament-latex::page';

    public FilamentLatex $filamentLatex;

    public string $latexContent = '';

    public function mount(int | string $record): void
    {
        $this->filamentLatex = FilamentLatex::findOrFail($record);
        $this->latexContent = $this->filamentLatex->content;

        // Compile document upon loading the page.
        $this->compileDocument();
    }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }

    public function getTitle(): string | Htmlable
    {
        return __('filament-latex::filament-latex.page.view-page-title');
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
                ->tooltip(__('filament-latex::filament-latex.download.tooltip'))
                ->icon('heroicon-o-document-arrow-down')
                ->action(fn () => $this->downloadDocument()),
            Action::make('compileAction')
                ->label(__('filament-latex::filament-latex.page.compile.action'))
                ->color('success')
                ->extraAttributes([
                    'class' => 'rounded-l-none',
                ])
                ->action(fn () => $this->compileDocument()),
        ];
    }
}
