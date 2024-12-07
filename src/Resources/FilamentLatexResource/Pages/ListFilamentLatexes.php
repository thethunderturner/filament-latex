<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource;

class ListFilamentLatexes extends ListRecords
{
    protected static string $resource = FilamentLatexResource::class;

    public function getTitle(): string | Htmlable
    {
        return config('filament-latex.list-page-title') ?? parent::getTitle();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(config('filament-latex.create-button-label') ?? 'Create'),
        ];
    }
}
