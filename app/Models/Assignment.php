<?php

declare(strict_types=1);

namespace App\Models;

use App\Helpers\Attachmentable;
use App\Helpers\Commentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $points
 * @property Classroom $classroom
 * @property User $owner
 * @property Carbon $due_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection $comments
 * @property Collection $attachments
 * @property Collection $submissions
 */
class Assignment extends Model implements Commentable, Attachmentable
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        "due_date" => "datetime",
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, "commentable");
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, "attachmentable");
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
