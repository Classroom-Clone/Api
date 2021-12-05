<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;

    public function definition(): array
    {
        return [
            "title" => $this->faker->sentence,
            "content" => $this->faker->paragraph(),
            "points" => $this->faker->randomElement([10, 20, 50, 100]),
            "due_date" => $this->faker->dateTimeBetween(now(), now()->endOfMonth()),
            "classroom_id" => Classroom::factory(),
            "user_id" => fn(array $attributes) => Classroom::query()->find($attributes["classroom_id"])->owner->id,
        ];
    }

    public function forRandomClassroom(): Factory
    {
        return $this->state(
            fn() => [
                "classroom_id" => Classroom::query()->inRandomOrder()->first()->id,
            ],
        );
    }
}
