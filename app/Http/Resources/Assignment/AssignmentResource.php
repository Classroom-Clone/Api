<?php

declare(strict_types=1);

namespace App\Http\Resources\Assignment;

use App\Http\Resources\Attachment\AttachmentResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "content" => $this->content,
            "points" => $this->points,
            "due_date" => $this->due_date,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "owner" => new UserResource($this->owner),
            "attachments" => AttachmentResource::collection($this->attachments),
        ];
    }
}
