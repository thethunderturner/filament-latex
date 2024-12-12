<?php

namespace TheThunderTurner\FilamentLatex\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

trait CanUseDocument
{
    /**
     * We pass the content as an argument.
     */
    protected function updateDocument(int $recordID, string $content): void
    {
        Storage::disk(config('filament-latex.storage'))->put($recordID . '/main.tex', $content);
    }

    /**
     * Update the record with the new content.
     *
     * @param  $record  Model The record to update.
     */
    protected function updateRecord(Model $record): void
    {
        $record->content = $this->latexContent;
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
        $this->updateDocument($this->record->id, $this->latexContent);
        $this->updateRecord($this->record);
        // ...
    }

    /**
     * Generate and download a PDF of the document.
     */
    public function downloadDocument(): StreamedResponse
    {
        $this->compileDocument();
        $recordID = $this->record->id;
        $storage = Storage::disk(config('filament-latex.storage'));

        $filePath = $storage->path($recordID . '/main.tex');
        $pdfDir = $storage->path($recordID . '/compiled');
        $pdfPath = $recordID . '/compiled/main.pdf';

        if (! $storage->exists($recordID . '/main.tex')) {
            throw new RuntimeException(sprintf(
                'LaTeX file not found at: %s',
                $filePath
            ));
        }

        if (! $storage->exists($recordID . '/compiled')) {
            $storage->makeDirectory($recordID . '/compiled');
        }

        // Build the pdflatex command
        $command = [
            config('filament-latex.parser'),
            '-interaction=nonstopmode',
            '-output-directory=' . $pdfDir,
            $filePath,
        ];

        try {
            $process = new Process($command);
            $process->setTimeout(config('filament-latex.compilation-timeout'));
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            throw new RuntimeException('Failed to compile the LaTeX document.', 0, $exception);
        }

        if ($storage->exists($pdfPath)) {
            return $storage->download($pdfPath, 'invoice.pdf', [
                'Content-Type' => 'application/pdf',
            ]);
        } else {
            throw new RuntimeException('PDF file does not exist after compilation.');
        }
    }
}
