<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            "content" => $this->faker->paragraph(),
            "user_id" => User::factory(),
        ];
    }

    public function forRandomUser(): Factory
    {
        return $this->state(
            fn() => [
                "user_id" => User::query()->inRandomOrder()->first()->id,
            ],
        );
    }
}
