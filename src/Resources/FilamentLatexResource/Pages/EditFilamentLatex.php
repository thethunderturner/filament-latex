<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\FilamentLatexResource;

class EditFilamentLatex extends EditRecord
{
    protected static string $resource = FilamentLatexResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
