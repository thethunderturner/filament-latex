<?php

namespace TheThunderTurner\FilamentLatex\Concerns;

use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use TheThunderTurner\FilamentLatex\Models\FilamentLatex;

/**
 * @property FilamentLatex $filamentLatex
 * @property string $latexContent
 */
trait CanUseDocument
{
    use Utils;

    /**
     * We pass the content as an argument.
     */
    protected function updateDocument(int $recordID, string $content): void
    {
        $this->getStorage()->put($recordID . '/files/main.tex', $content);
    }

    /**
     * Update the record with the new content.
     *
     * @param  $record  FilamentLatex The record to update.
     */
    protected function updateRecord(FilamentLatex $record, string $content): void
    {
        $record->content = $content;
        $record->save();
    }

    /**
     * Compile the document.
     *
     * STRATEGY:
     * When compiles, we overwrite .tex file at the
     * /storage/storage_name/filament-latex/{record-id} with the new content.
     *
     * We will update the content of the record with the new content.
     *
     * Then we use the pdflatex binary command to compile the .tex file.
     * and we store the .pdf file at compiled subdirectory.
     */
    public function compileDocument(): void
    {
        $recordID = $this->filamentLatex->id;

        $this->updateDocument($recordID, $this->latexContent);
        $this->updateRecord($this->filamentLatex, $this->latexContent);

        $storage = $this->getStorage();
        $filePath = $storage->path($recordID . '/files/main.tex');
        $pdfDir = $storage->path($recordID . '/compiled');

        if (! $storage->exists($recordID . '/files/main.tex')) {
            throw new RuntimeException(sprintf(
                'LaTeX file not found at: %s',
                $filePath
            ));
        }

        if (! $storage->exists($recordID . '/files/compiled')) {
            $storage->makeDirectory($recordID . '/compiled');
        }

        // Build the pdflatex command
        $command = [
            config('filament-latex.parser'),
            '-halt-on-error',
            '-output-directory=' . $pdfDir,
            $filePath,
        ];

        // Run the pdflatex command
        $result = Process::timeout(config('filament-latex.compilation-timeout'))->run($command);

        // Mimic grep behavior to check for specific LaTeX errors
        $output = $result->output();
        $errorPattern = '/^!.*$/m'; // Match lines starting with '!'
        if (preg_match($errorPattern, $output) || $result->failed()) {
            Notification::make()
                ->title(__('filament-latex::filament-latex.page.compile.error-title'))
                ->color('danger')
                ->body(__('filament-latex::filament-latex.page.compile.error-body'))
                ->send();

            Log::error('LaTeX compilation failed:', [
                'output' => $result->output(),
                'error' => $result->errorOutput(),
            ]);
        } else {
            Notification::make()
                ->title(__('filament-latex::filament-latex.page.compile.success-title'))
                ->color('success')
                ->body(__('filament-latex::filament-latex.page.compile.success-body'))
                ->send();

            $this->dispatch('document-compiled');

        }
    }

    /**
     * Download the compiled document.
     */
    public function downloadDocument(): BinaryFileResponse
    {
        $this->compileDocument();

        $recordID = $this->filamentLatex->id ?? null;
        $storage = Storage::disk(config('filament-latex.storage'));
        $pdfPath = $recordID . '/compiled/main.pdf';

        if ($storage->exists($pdfPath)) {
            return response()->download($storage->path($pdfPath), 'invoice.pdf', [
                'Content-Type' => 'application/pdf',
            ]);
        } else {
            throw new RuntimeException('PDF file does not exist after compilation.');
        }
    }

    /**
     * @throws Exception
     */
    #[On('document-compiled')]
    public function getPdfUrl(): string
    {
        return route('filament.' . filament()->getCurrentPanel()->getId() . '.auth.file', ['recordID' => $this->filamentLatex->id]);
    }
}
