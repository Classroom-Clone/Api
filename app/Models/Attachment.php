<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $path
 * @property string $original
 * @property string $mime_type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 * @property Post $post
 * @property Assignment $assignment
 * @property Submission $submission
 */
class Attachment extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $guarded = [];
    protected $keyType = "string";

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attachmentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function post(): MorphOne
    {
        return $this->morphOne(Post::class, "attachmentable");
    }

    public function assignment(): MorphOne
    {
        return $this->morphOne(Assignment::class, "attachmentable");
    }

    public function submission(): MorphOne
    {
        return $this->morphOne(Submission::class, "attachmentable");
    }
}
