<?php

declare(strict_types=1);

namespace App\Http\Resources\Member;

use App\Http\Resources\PaginatedCollection;

class MemberCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "pagination" => $this->paginationData(),
        ];
    }
}
