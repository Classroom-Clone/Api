<?php

declare(strict_types=1);

namespace App\Http\Resources\Attachment;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class AttachmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "display_name" => $this->original,
            "url" => URL::signedRoute("attachment.download", [
                "attachment" => $this,
            ]),
        ];
    }
}
