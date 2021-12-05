<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            "title" => $this->faker->sentence,
            "content" => $this->faker->paragraph(),
            "classroom_id" => Classroom::factory(),
            "user_id" => fn(array $attributes) => Classroom::query()->find($attributes["classroom_id"])->owner->id,
        ];
    }
}
