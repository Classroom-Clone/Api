<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Attachment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Traits\ManagesAssignments;
use Tests\Traits\ManagesAttachments;
use Tests\Traits\ManagesPosts;
use Tests\Traits\ManagesSubmissions;
use Tests\Traits\ManagesUsers;

class AttachmentTest extends TestCase
{
    use RefreshDatabase;
    use ManagesUsers;
    use ManagesPosts;
    use ManagesAssignments;
    use ManagesSubmissions;
    use ManagesAttachments;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake();
    }

    public function testUserCanSeeAttachmentsForPost(): void
    {
        $user = $this->createUser();
        $post = $this->createPost();
        $this->createAttachmentsFor($post, 10);

        $this->actingAs($user)
            ->get("/posts/{$post->id}")
            ->assertSuccessful()
            ->assertJsonCount(10, "data.attachments");
    }

    public function testUserCanSeeAttachmentsForAssignment(): void
    {
        $user = $this->createUser();
        $assignment = $this->createAssignment();
        $this->createAttachmentsFor($assignment, 10);

        $this->actingAs($user)
            ->get("/assignments/{$assignment->id}")
            ->assertSuccessful()
            ->assertJsonCount(10, "data.attachments");
    }

    public function testUserCanSeeAttachmentsForSubmission(): void
    {
        $user = $this->createUser();
        $submission = $this->createSubmission();
        $this->createAttachmentsFor($submission, 10);

        $this->actingAs($user)
            ->get("/submissions/{$submission->id}")
            ->assertSuccessful()
            ->assertJsonCount(10, "data.attachments");
    }

    public function testUserCanUploadAttachment(): void
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->post("/attachments", [
                "file" => UploadedFile::fake()->create("fake.pdf"),
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("attachments", [
            "original" => "fake.pdf",
            "user_id" => $user->id,
        ]);

        $attachment = Attachment::query()->first();

        Storage::assertExists("attachments/{$attachment->id}");
    }

    public function testUserCanDeleteAttachment(): void
    {
        $user = $this->createUser();
        $attachment = $this->createAttachment();

        $this->assertModelExists($attachment);
        Storage::assertExists("attachments/{$attachment->id}");

        $this->actingAs($user)
            ->delete("/attachments/{$attachment->id}")
            ->assertSuccessful();

        $this->assertDeleted($attachment);
        Storage::assertMissing("attachments/{$attachment->id}");
    }

    public function testUserCanAttachFileToSubmission(): void
    {
        $user = $this->createUser();
        $submission = $this->createSubmission();
        $attachment = $this->createAttachmentFor($submission);

        $this->actingAs($user)
            ->post("/submissions/{$submission->id}/attachments", [
                "attachment_id" => $attachment->id,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("attachments", [
            "id" => $attachment->id,
            "attachmentable_id" => $submission->id,
            "attachmentable_type" => $submission->getMorphClass(),
        ]);
    }

    public function testUserCanDetachFileToSubmission(): void
    {
        $user = $this->createUser();
        $submission = $this->createSubmission();
        $attachment = $this->createAttachmentFor($submission);

        $this->actingAs($user)
            ->delete("/submissions/{$submission->id}/attachments/{$attachment->id}")
            ->assertSuccessful();

        $this->assertDeleted($attachment);
        Storage::assertMissing("attachments/{$attachment->id}");
    }
}
