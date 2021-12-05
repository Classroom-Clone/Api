<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Tests\Traits\ManagesAssignments;
use Tests\Traits\ManagesClassrooms;
use Tests\Traits\ManagesUsers;

class AssignmentTest extends TestCase
{
    use RefreshDatabase;
    use ManagesUsers;
    use ManagesClassrooms;
    use ManagesAssignments;

    public function testUserCanSeeAssignmentsForSpecificClassroom(): void
    {
        $user = $this->createUser();
        $classroom = $this->createClassroom();
        $this->createAssignmentsFor($classroom, 10);

        $this->actingAs($user)
            ->get("/classrooms/{$classroom->id}/assignments")
            ->assertSuccessful()
            ->assertJsonCount(10, "data");
    }

    public function testUserCanSeePost(): void
    {
        $user = $this->createUser();
        $assignment = $this->createAssignment();

        $this->actingAs($user)
            ->get("/assignments/{$assignment->id}")
            ->assertSuccessful()
            ->assertJsonFragment([
                "id" => $assignment->id,
            ]);
    }

    public function testUserCanCreatePost(): void
    {
        Carbon::setTestNow(now());

        $user = $this->createUser();
        $classroom = $this->createClassroom();

        $this->actingAs($user)
            ->post("/classrooms/{$classroom->id}/assignments", [
                "title" => "My title",
                "content" => "My content",
                "points" => 100,
                "due_date" => now()->endOfWeek()->toDateTimeString(),
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("assignments", [
            "title" => "My title",
            "content" => "My content",
            "points" => 100,
            "due_date" => now()->endOfWeek()->toDateTimeString(),
            "classroom_id" => $classroom->id,
            "user_id" => $user->id,
        ]);
    }

    public function testUserCanUpdatePost(): void
    {
        $user = $this->createUser();
        $assignment = $this->createAssignment();

        $this->actingAs($user)
            ->put("/assignments/{$assignment->id}", [
                "title" => $assignment->title,
                "content" => "Changed content",
                "points" => 50,
                "due_date" => $assignment->due_date->toDateTimeString(),
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("assignments", [
            "title" => $assignment->title,
            "content" => "Changed content",
            "points" => 50,
            "due_date" => $assignment->due_date->toDateTimeString(),
        ]);
    }

    public function testUserCanDeletePost(): void
    {
        $user = $this->createUser();
        $assignment = $this->createAssignment();

        $this->assertModelExists($assignment);

        $this->actingAs($user)
            ->delete("/assignments/{$assignment->id}")
            ->assertSuccessful();

        $this->assertDeleted($assignment);
    }
}
