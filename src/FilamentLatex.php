<?php

namespace TheThunderTurner\FilamentLatex;

use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;

class FilamentLatex extends Page
{
    protected static string $view = 'filament-latex::page';

    protected static ?string $navigationIcon = 'heroicon-o-musical-note';

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }
}
