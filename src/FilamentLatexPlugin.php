<?php

namespace TheThunderTurner\FilamentLatex;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Auth\Middleware\Authenticate;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource;

class FilamentLatexPlugin implements Plugin
{
    protected ?string $resource = null;

    public function getId(): string
    {
        return 'filament-latex';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                $this->getResource(),
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

    public function getResource(): string
    {
        return $this->resource ?? config('filament-latex.resource');
    }

    public function resource(string $resource): static
    {
        $this->resource = $resource;

        return $this;
    }
}
