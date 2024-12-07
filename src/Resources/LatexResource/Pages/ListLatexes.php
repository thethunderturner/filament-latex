<?php

namespace TheThunderTurner\FilamentLatex\Resources\LatexResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use TheThunderTurner\FilamentLatex\Resources\LatexResource\LatexResource;

class ListLatexes extends ListRecords
{
    protected static string $resource = LatexResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
