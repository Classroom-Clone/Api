<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentObserver
{
    public function creating(Attachment $attachment): void
    {
        if ($attachment->id === null) {
            $attachment->id = Str::uuid()->toString();
        }
    }

    public function deleted(Attachment $attachment): void
    {
        Storage::deleteDirectory("attachments/{$attachment->id}");
    }
}
