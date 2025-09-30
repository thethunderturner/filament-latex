<?php

namespace TheThunderTurner\FilamentLatex\Concerns;

use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

trait CanUploadFiles
{
    use Utils;

    protected string $extension;

    protected string $renamedFileHelperText = '';

    /**
     * Uploads a file.
     */
    public function uploadAction(): Action
    {
        return Action::make('upload')
            ->requiresConfirmation()
            ->label(__('filament-latex::filament-latex.page.file-upload.title'))
            ->modalIcon(__('filament-latex::filament-latex.page.file-upload.icon'))
            ->modalHeading(__('filament-latex::filament-latex.page.file-upload.heading'))
            ->modalDescription(__('filament-latex::filament-latex.page.file-upload.description'))
            ->modalSubmitActionLabel(__('filament-latex::filament-latex.page.file-upload.submit'))
            ->color('success')
            ->icon('heroicon-o-document-arrow-up')
            ->extraAttributes([
                'class' => 'w-full',
            ])
            ->schema([
                FileUpload::make('attachment')
                    ->required()
                    ->disk(config('filament-latex.storage'))
                    ->directory($this->filamentLatex->id . '/files')
                    ->visibility('private')
                    ->preserveFilenames()
                    ->multiple()
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file) {
                        $storage = Storage::disk(config('filament-latex.storage'));
                        $directory = $this->filamentLatex->id . '/files';
                        $originalName = $file->getClientOriginalName();
                        $path = $directory . '/' . $originalName;

                        if (! $storage->exists($path)) {
                            return $originalName;
                        }

                        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                        $filename = pathinfo($originalName, PATHINFO_FILENAME);
                        $counter = 1;

                        while (true) {
                            $newFilename = $filename . ' (' . $counter . ')' . ($extension ? '.' . $extension : '');
                            $newPath = $directory . '/' . $newFilename;

                            if (! $storage->exists($newPath)) {
                                return $newFilename;
                            }

                            $counter++;
                        }
                    }),
            ]);
    }

    /**
     * Deletes a file.
     */
    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->icon('heroicon-o-trash')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function ($arguments) {
                return $this->canDeleteFile($arguments);
            });
    }

    /**
     * Renames a file.
     */
    public function renameAction(): Action
    {
        return Action::make('rename')
            ->icon('heroicon-o-pencil')
            ->color('warning')
            ->schema(function (array $arguments) {
                $this->extension = pathinfo($arguments['file'], PATHINFO_EXTENSION);

                return [
                    TextInput::make('name')
                        ->label(__('filament-latex::filament-latex.page.rename.label'))
                        ->required()
                        ->live()
                        ->rules([
                            function () {
                                return function (string $attribute, $value, Closure $fail) {
                                    $newDirectory = $this->filamentLatex->id . '/files/' . $value . '.' . $this->extension;

                                    if ($this->getStorage()->exists($newDirectory)) {
                                        $fail(__('filament-latex::filament-latex.page.rename.helper'));
                                    }
                                };
                            },
                        ])
                        ->suffix($this->extension ? '.' . $this->extension : ''),
                ];
            })
            ->action(function (Action $action, $data, array $arguments) {
                $newDirectory = $this->filamentLatex->id . '/files/' . $data['name'] . '.' . $this->extension;
                $oldDirectory = $this->filamentLatex->id . '/files/' . $arguments['file'];

                $this->getStorage()->move($oldDirectory, $newDirectory);
            });
    }
}
