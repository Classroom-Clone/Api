<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Helpers\Attachmentable;
use App\Models\Attachment;
use App\Models\Post;
use Illuminate\Support\Collection;

trait ManagesAttachments
{
    public function createAttachment(array $data = []): Attachment
    {
        /** @var Attachment $attachment */
        $attachment = Attachment::factory($data)
            ->for(Post::factory(), "attachmentable")
            ->create();

        return $attachment;
    }

    public function createAttachmentFor(Attachmentable $attachmentable, array $data = []): Attachment
    {
        /** @var Attachment $attachment */
        $attachment = Attachment::factory($data)
            ->for($attachmentable, "attachmentable")
            ->create();

        return $attachment;
    }

    public function createAttachments(int $count = 5): Collection
    {
        return Attachment::factory()
            ->for(Post::factory(), "attachmentable")
            ->count($count)
            ->create();
    }

    public function createAttachmentsFor(Attachmentable $attachmentable, int $count = 5): Collection
    {
        return Attachment::factory()
            ->for($attachmentable, "attachmentable")
            ->count($count)
            ->create();
    }
}
