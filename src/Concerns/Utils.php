<?php

namespace TheThunderTurner\FilamentLatex\Concerns;

use Exception;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use TheThunderTurner\FilamentLatex\Models\FilamentLatex;

/**
 * @property FilamentLatex $filamentLatex
 * @property string $latexContent
 */
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
        if (! Str::endsWith($arguments['file'], '.tex')) {
            return $this->getStorage()->delete($this->filamentLatex->id . '/files/' . $arguments['file']);
        } else {
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

    /**
     * Checks if PDF.js should display the whole pdf,
     * or show each page separately.
     *
     * @return bool
     */
    public function paginate(): bool
    {
        return config('filament-latex.paginate') ?? false;
    }

    /**
     * Checks if PDF.js should be used to display the pdf or
     * the browser's default PDF viewer.
     *
     * @return bool
     */
    public function usePdfJs(): bool
    {
        return config('filament-latex.pdf-js') ?? true;
    }

    /**
     * @throws Exception
     */
    public function getUserModel(): string
    {
        $userModel = config('filament-latex.user-model');

        if (! $userModel || ! class_exists($userModel) || ! is_subclass_of($userModel, Model::class)) {
            throw new Exception('User model is not set or is not a valid Eloquent model class');
        }

        return $userModel;
    }
}
