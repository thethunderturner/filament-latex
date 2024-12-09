<?php

namespace TheThunderTurner\FilamentLatex\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

trait CanUseDocument
{
    /**
     * Generate and download a PDF of the document.
     */
    public function downloadDocument(): void
    {
        // Get the file from storage, and then use pdf latex binary to generate the pdf.

    }

    /**
     * We pass the content as an argument.
     *
     * @param  $content  string The content of the document.
     *
     * @returns void
     */
    protected function updateDocument(string $content): void
    {
        Storage::disk(config('filament-latex.storage'))->put($this->record->id . '/main.tex', $content);
    }

    /**
     * Update the record with the new content.
     *
     * @param  $record  Model The record to update.
     * @param  $content  string The new content.
     *
     * @returns void
     */
    protected function updateRecord(Model $record, string $content): void
    {
        $record->content = $content;
        $record->save();
    }

    /**
     * Compile the document.
     *
     * STRATEGY:
     * When compiles, we create a .tex file at the
     * /storage/storage_name/filament-latex/{record-id} directory.
     *
     * Then we use the pdflatex binary command to compile the .tex file.
     * and we store the .pdf file at the same directory, or we find a way to stream
     * it to the preview div.
     *
     * If the user presses download, then we compile, generate the pdf and download it.
     */
    public function compileDocument(): void
    {
        $this->updateDocument($this->latexContent);
        // ...
    }
}
