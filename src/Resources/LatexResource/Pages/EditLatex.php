<?php

namespace TheThunderTurner\FilamentLatex\Resources\LatexResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use TheThunderTurner\FilamentLatex\Resources\LatexResource\LatexResource;

class EditLatex extends EditRecord
{
    protected static string $resource = LatexResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
