<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use TheThunderTurner\FilamentLatex\Http\Controllers\FileController;

Route::get(config('filament-latex.storage-url') .'/{recordID}', [FileController::class, 'getPrivateFile'])
    ->name('pdf.download');
