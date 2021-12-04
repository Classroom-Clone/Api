<?php

declare(strict_types=1);

namespace App\Http\Resources\Classroom;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassroomResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "color" => $this->accent_color,
            "invite_code" => $this->invite_code,
            "is_archived" => $this->isArchived(),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "archived_at" => $this->when($this->isArchived(), $this->archived_at),
        ];
    }
}
