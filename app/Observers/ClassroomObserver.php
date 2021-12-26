<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Classroom;
use Illuminate\Support\Str;

class ClassroomObserver
{
    public function creating(Classroom $classroom): void
    {
        if ($classroom->join_code === null) {
            $classroom->join_code = Str::random(24);
        }
    }
}
