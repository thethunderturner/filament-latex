<?php

namespace TheThunderTurner\FilamentLatex;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Facades\FilamentAsset;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentLatexServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-latex';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        Livewire::component('filament-latex', FilamentLatex::class);

        FilamentAsset::register(
            assets: [
                AlpineComponent::make('filament-latex', __DIR__ . '/../resources/dist/filament-latex.js'),
            ],
            package: 'thethunderturner/filament-latex'
        );
    }
}
