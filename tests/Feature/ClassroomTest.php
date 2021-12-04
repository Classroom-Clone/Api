<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Tests\Traits\CreatesClassrooms;
use Tests\Traits\CreatesUsers;

class ClassroomTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;
    use CreatesClassrooms;

    public function testUserCanSeeOwnedClassrooms(): void
    {
        $user = $this->createUser();
        $this->createClassroomsFor($user, 3);

        $this->actingAs($user)
            ->get("/me/owned-classrooms")
            ->assertSuccessful()
            ->assertJsonCount(3, "data");
    }

    public function testUserCanCreateClassroom(): void
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->post("/classrooms", [
                "name" => "My classroom",
                "description" => "My description",
                "accent_color" => "#FFFFFF",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("classrooms", [
            "name" => "My classroom",
            "description" => "My description",
            "accent_color" => "#FFFFFF",
        ]);
    }

    public function testUserCanUpdateClassroom(): void
    {
        $user = $this->createUser();
        $classroom = $this->createClassroomFor($user);

        $this->actingAs($user)
            ->put("/classrooms/{$classroom->id}", [
                "id" => $classroom->id,
                "name" => $classroom->name,
                "description" => $classroom->description,
                "accent_color" => "#F6F6F6",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("classrooms", [
            "name" => $classroom->name,
            "description" => $classroom->description,
            "accent_color" => "#F6F6F6",
        ]);
    }

    public function testUserCanDeleteClassroom(): void
    {
        $user = $this->createUser();
        $classroom = $this->createClassroomFor($user);

        $this->assertModelExists($classroom);

        $this->actingAs($user)
            ->delete("/classrooms/{$classroom->id}")
            ->assertSuccessful();

        $this->assertDeleted($classroom);
    }

    public function testUserCanArchiveClassroom(): void
    {
        $user = $this->createUser();
        $classroom = $this->createClassroomFor($user);

        $this->assertFalse($classroom->isArchived());

        $this->actingAs($user)
            ->put("/classrooms/{$classroom->id}/archive")
            ->assertSuccessful();

        $classroom->refresh();

        $this->assertTrue($classroom->isArchived());
    }

    public function testUserCanUnarchiveClassroom(): void
    {
        $user = $this->createUser();
        $classroom = $this->createClassroomFor($user, [
            "archived_at" => Carbon::now(),
        ]);

        $this->assertTrue($classroom->isArchived());

        $this->actingAs($user)
            ->delete("/classrooms/{$classroom->id}/archive")
            ->assertSuccessful();

        $classroom->refresh();

        $this->assertFalse($classroom->isArchived());
    }
}
