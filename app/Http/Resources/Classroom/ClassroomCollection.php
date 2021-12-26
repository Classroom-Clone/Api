<?php

declare(strict_types=1);

namespace App\Http\Resources\Classroom;

use App\Http\Resources\PaginatedCollection;

class ClassroomCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "pagination" => $this->paginationData(),
        ];
    }
}
