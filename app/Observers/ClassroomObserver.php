<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Classroom;
use Illuminate\Support\Str;

class ClassroomObserver
{
    public function creating(Classroom $classroom): void
    {
        if ($classroom->invite_code === null) {
            $classroom->invite_code = Str::random(24);
        }
    }
}
