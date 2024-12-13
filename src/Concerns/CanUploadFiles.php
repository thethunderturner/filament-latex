<?php

namespace TheThunderTurner\FilamentLatex\Concerns;

use Filament\Actions\Action;

trait CanUploadFiles
{
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
}
