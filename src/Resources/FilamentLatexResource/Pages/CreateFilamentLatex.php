<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use TheThunderTurner\FilamentLatex\Concerns\CanUseDocument;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource;

class CreateFilamentLatex extends CreateRecord
{
    use CanUseDocument;

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

    /**
     * File creation hook.
     *
     * Important Context: The parsers needs something to render!
     * Having just the document class and a comment won't produce a PDF.
     * Therefore, in the preview you will just get a 404 message.
     */
    protected function afterCreate(): void
    {
        $defaultContent = <<<'LATEX'
            \documentclass{article}
            \usepackage{graphicx}
            \graphicspath{{../files/}}
            \begin{document}
            % Your content here
            Hello World
            \end{document}
            LATEX;

        $this->updateDocument($this->record->id ?? null, $defaultContent);
        $this->updateRecord($this->record, $defaultContent);
    }
}
