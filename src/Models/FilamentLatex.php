<?php

namespace TheThunderTurner\FilamentLatex\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $content
 * @property string $deadline
 * @property int $author_id
 * @property array $collaborators_id
 */
class FilamentLatex extends Model
{
    protected $fillable = ['name', 'content', 'attachment_file_names', 'deadline', 'author_id', 'collaborators_id'];

    protected $table = 'filament-latex';

    protected $casts = [
        'collaborators_id' => 'array',
        'attachment_file_names' => 'array',
    ];

    /**
     * @throws Exception
     */
    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo($this->getUserModel(), 'author_id');
    }

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
