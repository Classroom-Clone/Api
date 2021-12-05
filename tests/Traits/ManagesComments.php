<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Helpers\Commentable;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Collection;

trait ManagesComments
{
    public function createComment(array $data = []): Comment
    {
        /** @var Comment $comment */
        $comment = Comment::factory($data)
            ->for(Post::factory(), "commentable")
            ->create();

        return $comment;
    }

    public function createCommentFor(Post $post, array $data = []): Comment
    {
        /** @var Comment $comment */
        $comment = Comment::factory($data)
            ->for($post, "commentable")
            ->create();

        return $comment;
    }

    public function createComments(int $count = 5): Collection
    {
        return Comment::factory()
            ->for(Post::factory(), "commentable")
            ->count($count)
            ->create();
    }

    public function createCommentsFor(Commentable $commentable, int $count = 5): Collection
    {
        return Comment::factory()
            ->for($commentable, "commentable")
            ->count($count)
            ->create();
    }
}
