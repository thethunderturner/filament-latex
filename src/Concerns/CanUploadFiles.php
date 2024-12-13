<?php

namespace TheThunderTurner\FilamentLatex\Concerns;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;

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
                FileUpload::make('upload')
                    ->disk(config('filament-latex.storage'))
                    ->unique()
                    ->preserveFilenames()
                    ->directory($this->filamentLatex->id . '/files'),
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
            ->action(fn () => dd('delete'));
    }

    /**
     * Returns an array of files that have been
     * uploaded to the record.
     */
    public function getFiles(): array
    {
        return Storage::disk(config('filament-latex.storage'))->files($this->filamentLatex->id . '/files');
    }
}
