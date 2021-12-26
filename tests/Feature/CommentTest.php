<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\ManagesAssignments;
use Tests\Traits\ManagesComments;
use Tests\Traits\ManagesPosts;
use Tests\Traits\ManagesSubmissions;
use Tests\Traits\ManagesUsers;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    use ManagesUsers;
    use ManagesPosts;
    use ManagesAssignments;
    use ManagesSubmissions;
    use ManagesComments;

    public function testUserCanSeeCommentsForPost(): void
    {
        $user = $this->createUser();
        $post = $this->createPost();
        $this->createCommentsFor($post, 10);

        $this->actingAs($user)
            ->get("/posts/{$post->id}/comments")
            ->assertSuccessful()
            ->assertJsonCount(10, "data");
    }

    public function testUserCanCreateCommentForPost(): void
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

    public function testUserCanSeeCommentsForAssignment(): void
    {
        $user = $this->createUser();
        $assignment = $this->createAssignment();
        $this->createCommentsFor($assignment, 10);

        $this->actingAs($user)
            ->get("/assignments/{$assignment->id}/comments")
            ->assertSuccessful()
            ->assertJsonCount(10, "data");
    }

    public function testUserCanCreateCommentForAssignment(): void
    {
        $user = $this->createUser();
        $assignment = $this->createAssignment();

        $this->actingAs($user)
            ->post("/assignments/{$assignment->id}/comments", [
                "content" => "My content",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("comments", [
            "content" => "My content",
            "commentable_id" => $assignment->id,
            "commentable_type" => $assignment->getMorphClass(),
            "user_id" => $user->id,
        ]);
    }

    public function testUserCanSeeCommentsForSubmission(): void
    {
        $user = $this->createUser();
        $submission = $this->createSubmission();
        $this->createCommentsFor($submission, 10);

        $this->actingAs($user)
            ->get("/submissions/{$submission->id}/comments")
            ->assertSuccessful()
            ->assertJsonCount(10, "data");
    }

    public function testUserCanCreateCommentForSubmission(): void
    {
        $user = $this->createUser();
        $submission = $this->createSubmission();

        $this->actingAs($user)
            ->post("/submissions/{$submission->id}/comments", [
                "content" => "My content",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("comments", [
            "content" => "My content",
            "commentable_id" => $submission->id,
            "commentable_type" => $submission->getMorphClass(),
            "user_id" => $user->id,
        ]);
    }

    public function testUserCanSeeComment(): void
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
