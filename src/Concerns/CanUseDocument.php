<?php

namespace TheThunderTurner\FilamentLatex\Concerns;

use Filament\Notifications\Notification;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

trait CanUseDocument
{
    public function getStorage(): Filesystem
    {
        return Storage::disk(config('filament-latex.storage'));
    }

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
     * @param  $record  Model The record to update.
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

        if ($result->failed()) {
            Notification::make()
                ->title('Compilation Error')
                ->color('danger')
                ->body('There was an error compiling the document.')
                ->send();

            Log::error('LaTeX compilation failed:', [
                'output' => $result->output(),
                'error' => $result->errorOutput(),
            ]);

            return;
        }

        // Mimic grep behavior to check for specific LaTeX errors
        $output = $result->output();
        $errorPattern = '/^!.*$/m'; // Match lines starting with '!'
        if (preg_match($errorPattern, $output)) {
            Notification::make()
                ->title('Compilation Error')
                ->color('danger')
                ->body('Errors were found in the LaTeX compilation output.')
                ->send();

            Log::info('Filtered LaTeX errors:', ['errors' => $output]);
        } else {
            Notification::make()
                ->title('Compilation Success')
                ->color('success')
                ->body('The document was compiled successfully.')
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

    #[On('document-compiled')]
    public function getPdfUrl(): string
    {
        return route('pdf.download', ['recordID' => $this->filamentLatex->id]);
    }
}
