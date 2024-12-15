<?php

namespace TheThunderTurner\FilamentLatex\Concerns;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;

trait CanUploadFiles
{
    /**
     * Uploads a file.
     */
    public function uploadAction(): Action
    {
        return Action::make('upload')
            ->color('success')
            ->label('Upload Files')
            ->icon('heroicon-o-document-arrow-up')
            ->requiresConfirmation()
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
                return $this->getStorage()->delete($this->filamentLatex->id . '/files/' . $arguments['file']);
            });
    }

    /**
     * Returns an array of files that have been
     * uploaded.
     *
     * All files are uploaded in files/ directory. In the future
     * we could add subdirectories for better organization.
     */
    public function getFiles(): array
    {
        return array_map('basename', $this->getStorage()->files($this->filamentLatex->id . '/files'));
    }
}
