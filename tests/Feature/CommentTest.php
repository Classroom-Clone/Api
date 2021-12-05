<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\ManagesComments;
use Tests\Traits\ManagesPosts;
use Tests\Traits\ManagesUsers;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    use ManagesUsers;
    use ManagesPosts;
    use ManagesComments;

    public function testUserCanSeeCommentsForSpecificPost(): void
    {
        $user = $this->createUser();
        $post = $this->createPost();
        $this->createCommentsFor($post, 10);

        $this->actingAs($user)
            ->get("/posts/{$post->id}/comments")
            ->assertSuccessful()
            ->assertJsonCount(10, "data");
    }

    public function testUserCanSeePost(): void
    {
        $user = $this->createUser();
        $comment = $this->createComment();

        $this->actingAs($user)
            ->get("/comments/{$comment->id}")
            ->assertSuccessful()
            ->assertJsonFragment([
                "id" => $comment->id,
            ]);
    }

    public function testUserCanCreateComment(): void
    {
        $user = $this->createUser();
        $post = $this->createPost();

        $this->actingAs($user)
            ->post("/posts/{$post->id}/comments", [
                "content" => "My content",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("comments", [
            "content" => "My content",
            "commentable_id" => $post->id,
            "commentable_type" => $post->getMorphClass(),
            "user_id" => $user->id,
        ]);
    }

    public function testUserCanUpdateComment(): void
    {
        $user = $this->createUser();
        $comment = $this->createComment();

        $this->actingAs($user)
            ->put("/comments/{$comment->id}", [
                "content" => "Changed content",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("comments", [
            "content" => "Changed content",
        ]);
    }

    public function testUserCanDeleteComment(): void
    {
        $user = $this->createUser();
        $comment = $this->createComment();

        $this->assertModelExists($comment);

        $this->actingAs($user)
            ->delete("/comments/{$comment->id}")
            ->assertSuccessful();

        $this->assertDeleted($comment);
    }
}
