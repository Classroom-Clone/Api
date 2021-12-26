<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\ManagesClassrooms;
use Tests\Traits\ManagesPosts;
use Tests\Traits\ManagesUsers;

class PostTest extends TestCase
{
    use RefreshDatabase;
    use ManagesUsers;
    use ManagesClassrooms;
    use ManagesPosts;

    public function testUserCanSeePostsForClassroom(): void
    {
        $user = $this->createUser();
        $classroom = $this->createClassroom();
        $this->createPostsFor($classroom, 10);

        $this->actingAs($user)
            ->get("/classrooms/{$classroom->id}/posts")
            ->assertSuccessful()
            ->assertJsonCount(10, "data");
    }

    public function testUserCanSeePost(): void
    {
        $user = $this->createUser();
        $post = $this->createPost();

        $this->actingAs($user)
            ->get("/posts/{$post->id}")
            ->assertSuccessful()
            ->assertJsonFragment([
                "id" => $post->id,
            ]);
    }

    public function testUserCanCreatePost(): void
    {
        $user = $this->createUser();
        $classroom = $this->createClassroom();

        $this->actingAs($user)
            ->post("/classrooms/{$classroom->id}/posts", [
                "title" => "My title",
                "content" => "My content",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("posts", [
            "title" => "My title",
            "content" => "My content",
            "classroom_id" => $classroom->id,
            "user_id" => $user->id,
        ]);
    }

    public function testUserCanCreatePostWithLinks(): void
    {
        $user = $this->createUser();
        $classroom = $this->createClassroom();

        $this->actingAs($user)
            ->post("/classrooms/{$classroom->id}/posts", [
                "title" => "My title",
                "content" => "My content",
                "links" => [
                    [
                        "name" => "Link #1",
                        "url" => "https://google.com",
                    ],
                ],
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("posts", [
            "title" => "My title",
            "content" => "My content",
            "classroom_id" => $classroom->id,
            "user_id" => $user->id,
        ]);

        $this->assertCount(1, $classroom->posts()->get());
    }

    public function testUserCanUpdatePost(): void
    {
        $user = $this->createUser();
        $post = $this->createPost();

        $this->actingAs($user)
            ->put("/posts/{$post->id}", [
                "title" => $post->title,
                "content" => "Changed content",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("posts", [
            "title" => $post->title,
            "classroom_id" => $post->classroom->id,
            "content" => "Changed content",
        ]);
    }

    public function testUserCanUpdatePostLinks(): void
    {
        $user = $this->createUser();
        $post = $this->createPost(links: 3);

        $this->assertCount(3, $post->links()->get());

        $this->actingAs($user)
            ->put("/posts/{$post->id}", [
                "title" => $post->title,
                "content" => $post->content,
                "links" => [
                    [
                        "name" => "Link #1",
                        "url" => "https://google.com",
                    ],
                ],
            ])
            ->assertSuccessful();

        $this->assertCount(1, $post->links()->get());
    }

    public function testUserCanDeletePost(): void
    {
        $user = $this->createUser();
        $post = $this->createPost();

        $this->assertModelExists($post);

        $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertSuccessful();

        $this->assertDeleted($post);
    }
}
