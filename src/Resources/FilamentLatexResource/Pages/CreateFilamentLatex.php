<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Storage;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource;

class CreateFilamentLatex extends CreateRecord
{
    protected static string $resource = FilamentLatexResource::class;

    public function getTitle(): string | Htmlable
    {
        return config('filament-latex.create-page-title') ?? parent::getTitle();
    }

    /**
     * Redirect to the document page after creating a new record.
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('document', ['record' => $this->record]);
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Created Document';
    }

    protected function afterCreate(): void
    {
        $defaultContent = <<<'LATEX'
            \documentclass{article}
            \begin{document}
            % Your content here
            \end{document}
            LATEX;

        Storage::disk(config('filament-latex.storage'))->put($this->record->id . '/main.tex', $defaultContent);
    }
}
