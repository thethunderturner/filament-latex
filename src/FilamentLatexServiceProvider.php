<?php

namespace TheThunderTurner\FilamentLatex;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentLatexServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-latex';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            ->hasConfigFile()
            ->hasMigrations($this->getMigrations())
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register(
            assets: [
                AlpineComponent::make('filament-latex', __DIR__ . '/../resources/dist/filament-latex.js'),
            ],
            package: 'thethunderturner/filament-latex'
        );
    }

    /**
     * Publish the package's SVG assets.
     */
    public function bootingPackage(): void
    {
        $this->publishes([
            $this->package->basePath('/../resources/svg') => base_path("resources/svg/vendor/{$this->packageView($this->package->viewNamespace)}"),
        ], "{$this->packageView($this->package->viewNamespace)}-svg");
    }

    protected function getMigrations(): array
    {
        return [
            'create_filament_latex_table',
        ];
    }
}
