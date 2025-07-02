<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\Support\Htmlable;
use TheThunderTurner\FilamentLatex\Concerns\CanUploadFiles;
use TheThunderTurner\FilamentLatex\Concerns\CanUseDocument;
use TheThunderTurner\FilamentLatex\Concerns\Utils;
use TheThunderTurner\FilamentLatex\Models\FilamentLatex;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource;

class ViewFilamentLatex extends Page implements HasActions, HasForms
{
    use CanUploadFiles;
    use CanUseDocument;
    use InteractsWithActions;
    use InteractsWithForms;
    use Utils;

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
                    'class' => 'rounded-none -mr-3',
                ])
                ->action(fn () => $this->compileDocument()),
            Action::make('options')
                ->hiddenLabel()
                ->color('success')
                ->tooltip(__('filament-latex::filament-latex.page.options.tooltip'))
                ->icon('heroicon-o-cog-6-tooth')
                ->extraAttributes([
                    'class' => 'rounded-l-none',
                ])
                ->requiresConfirmation()
                ->modalHeading(__('filament-latex::filament-latex.page.options.modal.heading', ['default' => 'Document Options']))
                ->modalDescription(__('filament-latex::filament-latex.page.options.modal.description', ['default' => 'Configure document compilation and display options']))
                ->modalSubmitActionLabel(__('filament-latex::filament-latex.page.options.modal.submit', ['default' => 'Save']))
                ->fillForm(fn (): array => [
                    'parser' => $this->filamentLatex->parser,
                    'strict_compilation' => $this->filamentLatex->strict_compilation,
                    'pdfjs' => $this->filamentLatex->pdfjs,
                    'paginate' => $this->filamentLatex->paginate,
                ])
                ->form([
                    Select::make('parser')
                        ->label(__('filament-latex::filament-latex.page.options.parser.label', ['default' => 'TeX Parser']))
                        ->native(false)
                        ->options(config('filament-latex.parsers')),
                    Select::make('strict_compilation')
                        ->label(__('filament-latex::filament-latex.page.options.compilation.label', ['default' => 'Compilation Options']))
                        ->native(false)
                        ->options([
                            true => 'Strict (halt on error)',
                            false => 'Non-strict (continue on error)',
                        ]),
                    Select::make('pdfjs')
                        ->label(__('filament-latex::filament-latex.page.options.display.label', ['default' => 'Display Options']))
                        ->native(false)
                        ->options([
                            true => 'Use PDF.js',
                            false => 'Use browser default',
                        ]),
                    Select::make('paginate')
                        ->label(__('filament-latex::filament-latex.page.options.display.paginate', ['default' => 'Display Options']))
                        ->native(false)
                        ->options([
                            true => 'Enabled',
                            false => 'Disabled',
                        ]),
                ])
                ->action(function (array $data): void {
                    // Update the current FilamentLatex instance with the new options
                    $this->filamentLatex->update([
                        'parser' => $data['parser'],
                        'strict_compilation' => $data['strict_compilation'],
                        'pdfjs' => $data['pdfjs'],
                        'paginate' => $data['paginate'],
                    ]);

                    Notification::make()
                        ->title(__('filament-latex::filament-latex.page.options.notification.title', ['default' => 'Options Updated']))
                        ->success()
                        ->send();
                }),
        ];
    }
}
