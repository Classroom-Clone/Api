<?php

declare(strict_types=1);

namespace App\Http\Resources\Comment;

use App\Http\Resources\PaginatedCollection;

class CommentCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "pagination" => $this->paginationData(),
        ];
    }
}
