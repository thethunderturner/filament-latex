<?php

namespace TheThunderTurner\FilamentLatex\Models;

use Illuminate\Database\Eloquent\Model;

class FilamentLatex extends Model
{
    protected $fillable = ['name', 'content'];

    protected $table = 'filament-latex';
}
