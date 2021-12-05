<?php

declare(strict_types=1);

namespace App\Http\Resources\Post;

use App\Http\Resources\PaginatedCollection;

class PostCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "pagination" => $this->paginationData(),
        ];
    }
}
