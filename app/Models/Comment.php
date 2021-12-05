<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $content
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Classroom $classroom
 * @property Post $post
 * @property Assignment $assignment
 * @property User $user
 */
class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function post(): MorphOne
    {
        return $this->morphOne(Post::class, "commentable");
    }

    public function assignment(): MorphOne
    {
        return $this->morphOne(Assignment::class, "commentable");
    }

    public function isEdited(): bool
    {
        return $this->created_at->notEqualTo($this->updated_at);
    }
}
