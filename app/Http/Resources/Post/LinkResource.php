<?php

declare(strict_types=1);

namespace App\Http\Resources\Post;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "name" => $this->name,
            "url" => $this->url,
        ];
    }
}
