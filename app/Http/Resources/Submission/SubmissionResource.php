<?php

declare(strict_types=1);

namespace App\Http\Resources\Submission;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "state" => $this->state,
            "points" => $this->points,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "user" => new UserResource($this->user),
        ];
    }
}
