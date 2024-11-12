<?php

namespace TheThunderTurner\FilamentLatex\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TheThunderTurner\FilamentLatex\FilamentLatex
 */
class FilamentLatex extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \TheThunderTurner\FilamentLatex\FilamentLatex::class;
    }
}
