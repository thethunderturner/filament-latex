<?php

namespace TheThunderTurner\FilamentLatex\Concerns;

use Filament\Notifications\Notification;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait Utils
{
    /**
     * Returns an array of files that have been
     * uploaded.
     *
     * All files are uploaded in files/ directory. In the future
     * we could add subdirectories for better organization.
     */
    public function getFiles(): array
    {
        return array_map('basename', $this->getStorage()->files($this->filamentLatex->id . '/files'));
    }

    /**
     * Returns the storage disk.
     */
    public function getStorage(): Filesystem
    {
        return Storage::disk(config('filament-latex.storage'));
    }

    /**
     * Checks if file can be deleted. It is extremely important that
     * the check is done here and not in the blade file as input data
     * can be manipulated!!
     */
    public function canDeleteFile(array $arguments): bool
    {
        $texFiles = collect($this->getFiles())->filter(fn ($file) => Str::endsWith($file, '.tex'));
        if ($texFiles->count() === 1) {
            Notification::make()
                ->title('You cannot delete the only ".tex" file in the project.')
                ->color('danger')
                ->send();

            return false;
        } else {
            return $this->getStorage()->delete($this->filamentLatex->id . '/files/' . $arguments['file']);
        }
    }
}
