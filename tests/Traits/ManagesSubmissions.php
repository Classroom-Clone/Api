<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Collection;

trait ManagesSubmissions
{
    public function createSubmission(array $data = []): Submission
    {
        /** @var Submission $submission */
        $submission = Submission::factory($data)
            ->create();

        return $submission;
    }

    public function createSubmissionFor(Assignment $assignment, array $data = []): Submission
    {
        /** @var Submission $submission */
        $submission = Submission::factory($data)
            ->for($assignment)
            ->create();

        return $submission;
    }

    public function createSubmissions(int $count = 5): Collection
    {
        return Submission::factory()
            ->count($count)
            ->create();
    }

    public function createSubmissionsFor(Assignment $assignment, int $count = 5): Collection
    {
        return Submission::factory()
            ->for($assignment)
            ->count($count)
            ->create();
    }
}
