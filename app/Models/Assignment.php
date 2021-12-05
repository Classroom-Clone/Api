<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

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
 */
class Assignment extends Model
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
}
