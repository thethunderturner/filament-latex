<?php

namespace TheThunderTurner\FilamentLatex\Concerns;

use Filament\Actions\Action;

trait CanUploadFiles
{
    /**
     * Uploads a file.
     *
     * @return Action
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
            ->action(fn () => dd($this->filamentLatex));
    }

    /**
     * Deletes a file.
     *
     * @return Action
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
}
