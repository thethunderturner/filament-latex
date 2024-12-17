<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource;

class EditFilamentLatex extends EditRecord
{
    protected static string $resource = FilamentLatexResource::class;

    public function getTitle(): string
    {
        return __('filament-latex::filament-latex.page.edit-page-title');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
