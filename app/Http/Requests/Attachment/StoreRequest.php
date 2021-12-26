<?php

declare(strict_types=1);

namespace App\Http\Requests\Attachment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * @property UploadedFile $file
 */
class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "file" => ["required", "file", "max:8096"],
        ];
    }

    public function getAttachmentData(): array
    {
        /** @var UploadedFile $file */
        $file = $this->file("file");
        $uuid = Str::uuid()->toString();

        return [
            "id" => $uuid,
            "user_id" => $this->user()->id,
            "path" => $file->storeAs("attachments/{$uuid}", $file->getClientOriginalName()),
            "original" => $file->getClientOriginalName(),
            "mime_type" => $file->getMimeType(),
        ];
    }
}
