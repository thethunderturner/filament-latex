<?php

namespace TheThunderTurner\FilamentLatex\Concerns;

use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
     * We pass the content and the slugged name as arguments.
     */
    protected function updateDocument(int $recordID, string $content, string $filename): void
    {
        $this->getStorage()->put($recordID . '/files/' . $filename . '.tex', $content);
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

    protected function getDocumentFilename(?string $name): string
    {
        $source = trim((string) $name);
        if ($source == '') {
            $source = 'document';
        }

        return Str::slug($source);
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
        $filename = $this->getDocumentFilename($this->record?->name);

        $this->updateDocument($recordID, $this->latexContent, $filename);
        $this->updateRecord($this->filamentLatex, $this->latexContent);

        $storage = $this->getStorage();
        $filePath = $storage->path($recordID . '/files/' . $filename . '.tex');
        $pdfDir = $storage->path($recordID . '/compiled');

        if (! $storage->exists($recordID . '/files/' . $filename . '.tex')) {
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
            $this->filamentLatex->parser,
            $this->filamentLatex->strict_compilation ? '-halt-on-error' : '-interaction=nonstopmode',
            '-output-directory=' . $pdfDir,
            $filePath,
        ];

        // File has to be deleted before compiling. This is because we need to check if a pdf can even be compiled.
        $storage->delete($recordID . '/compiled/' . $filename . '.pdf');

        // Get the directory containing the .tex file to use as working directory
        $workingDir = dirname($filePath);

        // Run the pdflatex command with the working directory set to the directory containing the .tex file
        $result = Process::timeout(config('filament-latex.compilation-timeout'))
            ->path($workingDir)
            ->run($command);

        // Check if the PDF file was generated
        if ($storage->exists($recordID . '/compiled/' . $filename . '.pdf')) {
            Notification::make()
                ->title(__('filament-latex::filament-latex.page.compile.success-title'))
                ->color('success')
                ->body(__('filament-latex::filament-latex.page.compile.success-body'))
                ->send();

            $this->dispatch('document-compiled');
        } else {
            Notification::make()
                ->title(__('filament-latex::filament-latex.page.compile.error-title'))
                ->color('danger')
                ->body(__('filament-latex::filament-latex.page.compile.error-body'))
                ->send();

            Log::error('LaTeX compilation failed:', [
                'output' => $result->output(),
                'error' => $result->errorOutput(),
            ]);
        }
    }

    /**
     * Download the compiled document.
     */
    public function downloadDocument(): BinaryFileResponse
    {
        $this->compileDocument();

        $recordID = $this->filamentLatex->id ?? null;
        $filename = $this->getDocumentFilename($this->filamentLatex->name);
        $storage = Storage::disk(config('filament-latex.storage'));
        $pdfPath = $recordID . '/compiled/' . $filename . '.pdf';

        if ($storage->exists($pdfPath)) {
            return response()->download($storage->path($pdfPath), $filename . '.pdf', [
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
