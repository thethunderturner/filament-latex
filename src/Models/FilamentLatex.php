<?php

namespace TheThunderTurner\FilamentLatex\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class FilamentLatex extends Model
{
    protected $fillable = ['name', 'content', 'deadline', 'author_id', 'collaborators_id'];

    protected $table = 'filament-latex';

    protected $casts = [
        'collaborators_id' => 'array',
    ];

    /**
     * @throws Exception
     */
    public function getUserModel(): string
    {
        $userModel = config('filament-latex.user-model');

        if (! $userModel || ! class_exists($userModel) || ! is_subclass_of($userModel, Model::class)) {
            throw new Exception('User model is not set or is not a valid Eloquent model class');
        }

        return $userModel;
    }
}
