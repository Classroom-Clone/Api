<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ClassroomFactory extends Factory
{
    protected $model = Classroom::class;

    public function definition(): array
    {
        return [
            "name" => $this->faker->domainName(),
            "description" => $this->faker->paragraph(),
            "join_code" => Str::random(24),
            "allow_join" => true,
            "accent_color" => $this->faker->hexColor(),
            "user_id" => User::factory(),
        ];
    }

    public function archived(): Factory
    {
        return $this->state(
            fn() => [
                "archived_at" => Carbon::now(),
            ],
        );
    }

    public function disabledJoining(): Factory
    {
        return $this->state(
            fn() => [
                "allow_join" => false,
            ],
        );
    }
}
