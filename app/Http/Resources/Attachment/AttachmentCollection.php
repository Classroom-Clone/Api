<?php

declare(strict_types=1);

namespace App\Http\Resources\Attachment;

use App\Http\Resources\PaginatedCollection;

class AttachmentCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "pagination" => $this->paginationData(),
        ];
    }
}
