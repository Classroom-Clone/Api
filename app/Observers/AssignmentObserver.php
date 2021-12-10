<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Assignment;

class AssignmentObserver
{
    public function created(Assignment $assignment): void
    {
        $members = $assignment->classroom->members;

        foreach ($members as $member) {
            $assignment->submissions()->create([
                "user_id" => $member->id,
            ]);
        }
    }
}
