<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SubmissionState;
use App\Helpers\Commentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property SubmissionState $state
 * @property int $points
 * @property Assignment $assignment
 * @property User $owner
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection $comments
 */
class Submission extends Model implements Commentable
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        "state" => SubmissionState::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, "commentable");
    }

    public function changeStateTo(SubmissionState $state): void
    {
        $this->state = $state;

        $this->save();
    }
}
