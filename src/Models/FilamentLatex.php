<?php

namespace TheThunderTurner\FilamentLatex\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public function author(): BelongsTo
    {
        return $this->belongsTo($this->getUserModel(), 'author_id');
    }

    /**
     * @throws Exception
     */
    public function getAuthorName()
    {
        return $this->author?->name;
    }

    /**
     * @throws Exception
     */
    public function getCollaboratorsAvatars()
    {
        $userIds = $this->collaborators_id ?? [];
        $userModel = $this->getUserModel();

        return $userModel::whereIn('id', $userIds)->pluck('avatar_url')->toArray();
    }

    /**
     * @throws Exception
     */
    public function getAuthorAvatar()
    {
        return $this->author?->avatar_url;
    }

    /**
     * @throws Exception
     */
    private function getUserModel(): string
    {
        $userModel = config('filament-latex.user-model');

        if (!$userModel || !class_exists($userModel) || !is_subclass_of($userModel, Model::class)) {
            throw new Exception('User model is not set or is not a valid Eloquent model class');
        }

        return $userModel;
    }
}
