<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Link;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{
    protected $model = Link::class;

    public function definition(): array
    {
        return [
            "name" => $this->faker->domainWord(),
            "url" => $this->faker->url(),
            "post_id" => Post::factory(),
        ];
    }
}
