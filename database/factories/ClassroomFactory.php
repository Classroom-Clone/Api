<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ClassroomFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => $this->faker->domainName(),
            "description" => $this->faker->paragraph(),
            "invite_code" => Str::random(24),
            "accent_color" => $this->faker->hexColor(),
            "user_id" => User::factory(),
        ];
    }

    public function hasRandomOwner(): Factory
    {
        return $this->state(
            fn() => [
                "user_id" => User::query()->inRandomOrder()->first()->id,
            ],
        );
    }

    public function archived(): Factory
    {
        return $this->state(
            fn() => [
                "archived_at" => Carbon::now(),
            ],
        );
    }
}
