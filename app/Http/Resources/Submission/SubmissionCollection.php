<?php

declare(strict_types=1);

namespace App\Http\Resources\Submission;

use App\Http\Resources\PaginatedCollection;

class SubmissionCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "pagination" => $this->paginationData(),
        ];
    }
}
