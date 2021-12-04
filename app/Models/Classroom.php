<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $accent_color
 * @property string $invite_code
 * @property string $user_id
 * @property User $owner
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $archived_at
 */
class Classroom extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        "archived_at" => "datetime",
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function archive(): void
    {
        $this->archived_at = $this->freshTimestamp();
        $this->save();
    }

    public function unarchive(): void
    {
        $this->archived_at = null;
        $this->save();
    }

    public function isArchived(): bool
    {
        return $this->archived_at !== null;
    }

    public function scopeArchived(Builder $query): Builder
    {
        return $query->whereNotNull("archived_at");
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull("archived_at");
    }
}
