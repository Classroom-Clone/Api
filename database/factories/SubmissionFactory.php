<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\SubmissionState;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubmissionFactory extends Factory
{
    protected $model = Submission::class;

    public function definition(): array
    {
        return [
            "points" => $this->faker->randomElement([10, 20, 50, 100]),
            "state" => $this->faker->randomElement(SubmissionState::cases()),
            "assignment_id" => Assignment::factory(),
            "user_id" => User::factory(),
        ];
    }

    public function forRandomAssignment(): Factory
    {
        return $this->state(
            fn() => [
                "assignment_id" => Assignment::query()->inRandomOrder()->first()->id,
            ],
        );
    }
}
