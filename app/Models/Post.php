<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Classroom $classroom
 * @property User $owner
 * @property Collection $links
 * @property Collection $comments
 */
class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, "commentable");
    }
}
