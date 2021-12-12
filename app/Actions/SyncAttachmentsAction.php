<?php

declare(strict_types=1);

namespace App\Actions;

use App\Helpers\Attachmentable;
use App\Models\Attachment;
use Illuminate\Support\Collection;

class SyncAttachmentsAction
{
    public function execute(Attachmentable $attachmentable, Collection $requestAttachments): void
    {
        $toAttach = $requestAttachments->diff($attachmentable->attachments)->values();
        $toDetach = $attachmentable->attachments->diff($requestAttachments)->values();

        /** @var Attachment $attachment */
        foreach ($toDetach as $attachment) {
            $attachment->delete();
        }

        $attachmentable->attachments()->saveMany($toAttach);
    }
}
