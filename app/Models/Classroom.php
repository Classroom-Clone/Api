<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

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
 * @property Collection $members
 * @property Collection $posts
 * @property Collection $assignments
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

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
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
