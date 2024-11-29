<?php

namespace TheThunderTurner\FilamentLatex;

use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\Support\Htmlable;

class FilamentLatex extends Page
{
    protected static string $view = 'filament-latex::page';

    public static function getNavigationIcon(): ?string
    {
        return view('filament-latex::svg.latex');
    }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }
}
