<?php

namespace TheThunderTurner\FilamentLatex;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentLatexServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-latex';

    public static string $viewNamespace = 'filament-latex';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            ->hasConfigFile()
            ->hasRoute('web')
            ->hasMigrations($this->getMigrations())
            ->hasTranslations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('thethunderturner/filament-latex');
            });

        if (file_exists($package->basePath("/../config/{$package->name}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
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

    protected function getMigrations(): array
    {
        return [
            'create_filament_latex_table',
        ];
    }
}
