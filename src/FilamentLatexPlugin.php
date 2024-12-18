<?php

namespace TheThunderTurner\FilamentLatex;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Auth\Middleware\Authenticate;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource;

class FilamentLatexPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-latex';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                FilamentLatexResource::class,
            ]);
        $panel->authMiddleware([
            Authenticate::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
