<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\Assignment;
use App\Models\Classroom;
use Illuminate\Support\Collection;

trait ManagesAssignments
{
    public function createAssignment(array $data = []): Assignment
    {
        /** @var Assignment $assignment */
        $assignment = Assignment::factory($data)
            ->create();

        return $assignment;
    }

    public function createAssignmentFor(Classroom $classroom, array $data = []): Assignment
    {
        /** @var Assignment $assignment */
        $assignment = Assignment::factory($data)
            ->for($classroom)
            ->create();

        return $assignment;
    }

    public function createAssignments(int $count = 5): Collection
    {
        return Assignment::factory()
            ->count($count)
            ->create();
    }

    public function createAssignmentsFor(Classroom $classroom, int $count = 5): Collection
    {
        return Assignment::factory()
            ->for($classroom)
            ->count($count)
            ->create();
    }
}
