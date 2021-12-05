<?php

declare(strict_types=1);

namespace App\Http\Resources\Post;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "content" => $this->content,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "owner" => new UserResource($this->owner),
            "links" => LinkResource::collection($this->links),
        ];
    }
}
