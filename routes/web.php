<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use TheThunderTurner\FilamentLatex\Http\Controllers\FileController;

Route::name('filament.')->group(function () {
    foreach (Filament::getPanels() as $panel) {
        $domains = $panel->getDomains();

        foreach ((empty($domains) ? [null] : $domains) as $domain) {
            Route::domain($domain)
                ->middleware($panel->getMiddleware())
                ->name($panel->getId() . '.')
                ->prefix($panel->getPath())
                ->group(function () use ($panel) {
                    if ($panel->hasPlugin('filament-latex')) {
                        Route::get(config('filament-latex.storage-url') . '/{recordID}/document', [FileController::class, 'getPrivateFile'])
                            ->middleware('auth')
                            ->name('auth.file');
                    }
                });
        }
    }
});
