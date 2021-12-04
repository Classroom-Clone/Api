<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Support\Collection;

trait ManagesClassrooms
{
    public function createClassroom(array $data = []): Classroom
    {
        /** @var Classroom $classroom */
        $classroom = Classroom::factory($data)->create();

        return $classroom;
    }

    public function createClassroomFor(User $owner, array $data = []): Classroom
    {
        /** @var Classroom $classroom */
        $classroom = Classroom::factory($data)
            ->for($owner, "owner")
            ->create();

        return $classroom;
    }

    public function createClassrooms(int $count = 5): Collection
    {
        return Classroom::factory()
            ->count($count)
            ->create();
    }

    public function createClassroomsFor(User $owner, int $count = 5): Collection
    {
        return Classroom::factory()
            ->count($count)
            ->for($owner, "owner")
            ->create();
    }

    public function attachMembers(Classroom $classroom, User|Collection $members): void
    {
        $classroom->members()->attach($members);
    }
}
