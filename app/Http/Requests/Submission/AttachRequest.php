<?php

declare(strict_types=1);

namespace App\Http\Requests\Submission;

use App\Models\Attachment;
use Illuminate\Foundation\Http\FormRequest;

class AttachRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "attachment_id" => ["required", "exists:attachments,id"],
        ];
    }

    public function getAttachment(): Attachment
    {
        /** @var Attachment $attachment */
        $attachment = Attachment::query()->find($this->get("attachment_id"));

        return $attachment;
    }
}
