<?php

namespace TheThunderTurner\FilamentLatex\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilamentLatex extends Model
{
    protected $fillable = ['name', 'content', 'deadline', 'author', 'collaborators'];

    protected $table = 'filament-latex';

    protected $casts = [
        'collaborators' => 'array',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getCollaboratorsAvatars()
    {
        $userIds = $this->collaborators;

        return User::whereIn('id', $userIds)->pluck('avatar_url')->toArray();
    }

    public function getAuthorAvatar()
    {
        $user = User::find($this->author);

        return $user ? $user->avatar_url : null;
    }
}
