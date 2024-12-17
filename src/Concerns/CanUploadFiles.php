<?php

namespace TheThunderTurner\FilamentLatex\Concerns;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;

trait CanUploadFiles
{
    use Utils;

    /**
     * Uploads a file.
     */
    public function uploadAction(): Action
    {
        return Action::make('upload')
            ->requiresConfirmation()
            ->label(__('filament-latex::filament-latex.page.file-upload.title'))
            ->modalIcon(__('filament-latex::filament-latex.page.file-upload.icon'))
            ->modalHeading(__('filament-latex::filament-latex.page.file-upload.heading'))
            ->modalDescription(__('filament-latex::filament-latex.page.file-upload.description'))
            ->modalSubmitActionLabel(__('filament-latex::filament-latex.page.file-upload.submit'))
            ->color('success')
            ->icon('heroicon-o-document-arrow-up')
            ->extraAttributes([
                'class' => 'w-full',
            ])
            ->form([
                FileUpload::make('attachment')
                    ->required()
                    ->disk(config('filament-latex.storage'))
                    ->directory($this->filamentLatex->id . '/files')
                    ->visibility('private')
                    ->preserveFilenames(),
            ]);
    }

    /**
     * Deletes a file.
     */
    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->iconButton()
            ->icon('heroicon-o-trash')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function ($arguments) {
                return $this->canDeleteFile($arguments);
            });
    }
}
