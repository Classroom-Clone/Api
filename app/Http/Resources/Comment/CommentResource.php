<?php

declare(strict_types=1);

namespace App\Http\Resources\Comment;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "content" => $this->content,
            "is_edited" => $this->isEdited(),
            "author" => new UserResource($this->user),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
