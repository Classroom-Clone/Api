<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\Classroom;
use App\Models\Post;
use Illuminate\Support\Collection;

trait ManagesPosts
{
    public function createPost(array $data = [], int $links = 0): Post
    {
        /** @var Post $post */
        $post = Post::factory($data)
            ->hasLinks($links)
            ->create();

        return $post;
    }

    public function createPostFor(Classroom $classroom, array $data = [], int $links = 0): Post
    {
        /** @var Post $post */
        $post = Post::factory($data)
            ->for($classroom)
            ->hasLinks($links)
            ->create();

        return $post;
    }

    public function createPosts(int $count = 5): Collection
    {
        return Post::factory()
            ->count($count)
            ->create();
    }

    public function createPostsFor(Classroom $classroom, int $count = 5): Collection
    {
        return Post::factory()
            ->for($classroom)
            ->count($count)
            ->create();
    }
}
