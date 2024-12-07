<?php

namespace TheThunderTurner\FilamentLatex\Models;

use Illuminate\Database\Eloquent\Model;

class Latex extends Model
{
    protected $fillable = ['name', 'content'];

    protected $table = 'filament-latex';
}
