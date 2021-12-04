<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Tests\Traits\ManagesClassrooms;
use Tests\Traits\ManagesUsers;

class MemberTest extends TestCase
{
    use RefreshDatabase;
    use ManagesUsers;
    use ManagesClassrooms;

    public function testUserCanSeeClassroomMembers(): void
    {
        $user = $this->createUser();
        $classroom = $this->createClassroom();
        $this->attachMembers($classroom, $this->createUsers(10));

        $this->actingAs($user)
            ->get("/classrooms/{$classroom->id}/members")
            ->assertSuccessful()
            ->assertJsonCount(10, "data");
    }

    public function testUserCanAddMember(): void
    {
        $user = $this->createUser();
        $addingUser = $this->createUser();
        $classroom = $this->createClassroom();

        $this->assertCount(0, $classroom->members()->get());

        $this->actingAs($user)
            ->post("/classrooms/{$classroom->id}/members", [
                "user_id" => $addingUser->id,
            ])
            ->assertSuccessful();

        $this->assertCount(1, $classroom->members()->get());
    }

    public function testUserCanRemoveMember(): void
    {
        $user = $this->createUser();
        $members = $this->createUsers(10);
        $classroom = $this->createClassroomFor($user);
        $deletingUser = $members->first();
        $this->attachMembers($classroom, $members);

        $this->assertCount(10, $classroom->members()->get());

        $this->actingAs($user)
            ->delete("/classrooms/{$classroom->id}/members/{$deletingUser->id}")
            ->assertSuccessful();

        $this->assertCount(9, $classroom->members()->get());
    }

    public function testUserCanRemoveAllMembers(): void
    {
        $user = $this->createUser();
        $members = $this->createUsers(10);
        $classroom = $this->createClassroomFor($user);
        $this->attachMembers($classroom, $members);

        $this->assertCount(10, $classroom->members()->get());

        $this->actingAs($user)
            ->delete("/classrooms/{$classroom->id}/members")
            ->assertSuccessful();

        $this->assertCount(0, $classroom->members()->get());
    }
}
