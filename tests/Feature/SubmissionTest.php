<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\SubmissionState;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\ManagesAssignments;
use Tests\Traits\ManagesSubmissions;
use Tests\Traits\ManagesUsers;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;
    use ManagesUsers;
    use ManagesAssignments;
    use ManagesSubmissions;

    public function testUserCanSeeSubmissionsForSpecificAssignment(): void
    {
        $user = $this->createUser();
        $assignments = $this->createAssignment();

        $this->createSubmissionsFor($assignments, 10);

        $this->actingAs($user)
            ->get("/assignments/{$assignments->id}/submissions")
            ->assertSuccessful()
            ->assertJsonCount(10, "data");
    }

    public function testUserCanSeeSubmission(): void
    {
        $user = $this->createUser();
        $submission = $this->createSubmission();

        $this->actingAs($user)
            ->get("/submissions/{$submission->id}")
            ->assertSuccessful()
            ->assertJsonFragment([
                "id" => $submission->id,
            ]);
    }

    public function testUserCanReturnSubmission(): void
    {
        $user = $this->createUser();
        $submission = $this->createSubmission();

        $this->actingAs($user)
            ->put("/submissions/{$submission->id}/return")
            ->assertSuccessful();

        $this->assertDatabaseHas("submissions", [
            "state" => SubmissionState::RETURNED->value,
        ]);
    }

    public function testUserCanReclaimSubmission(): void
    {
        $user = $this->createUser();
        $submission = $this->createSubmission();

        $this->actingAs($user)
            ->put("/submissions/{$submission->id}/reclaim")
            ->assertSuccessful();

        $this->assertDatabaseHas("submissions", [
            "state" => SubmissionState::RECLAIMED->value,
        ]);
    }

    public function testUserCanEvaluateSubmission(): void
    {
        $user = $this->createUser();
        $assignment = $this->createAssignment([
            "points" => 50,
        ]);
        $submission = $this->createSubmissionFor($assignment);

        $this->actingAs($user)
            ->put("/submissions/{$submission->id}/evaluate", [
                "points" => 30,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("submissions", [
            "points" => 30,
            "state" => SubmissionState::EVALUATED->value,
        ]);
    }
}
