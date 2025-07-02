<?php

namespace TheThunderTurner\FilamentLatex\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TheThunderTurner\FilamentLatex\Concerns\Utils;

/**
 * @property int $id
 * @property string $name
 * @property string $content
 * @property string $deadline
 * @property int $author_id
 * @property array $collaborators_id
 * @property string $parser
 * @property bool $strict_compilation
 * @property bool $paginate
 * @property bool $pdfjs
 * @property bool $auto_recompile
 */
class FilamentLatex extends Model
{
    use Utils;

    protected $fillable = [
        'name',
        'content',
        'attachment',
        'attachment_file_names',
        'deadline', 'author_id',
        'collaborators_id',
        'parser',
        'strict_compilation',
        'paginate',
        'pdfjs',
        'auto_recompile',
    ];

    protected $table = 'filament-latex';

    protected $casts = [
        'collaborators_id' => 'array',
        'attachment' => 'array',
        'attachment_file_names' => 'array',
    ];

    /**
     * @throws Exception
     */
    public function author(): BelongsTo
    {
        return $this->BelongsTo($this->getUserModel(), 'author_id');
    }
}
