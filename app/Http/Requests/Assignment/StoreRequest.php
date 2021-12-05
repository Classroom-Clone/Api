<?php

declare(strict_types=1);

namespace App\Http\Requests\Assignment;

class StoreRequest extends BaseRequest
{
    public function getAssignmentData(): array
    {
        return [
            "title" => $this->get("title"),
            "content" => $this->get("content"),
            "points" => $this->get("points"),
            "due_date" => $this->get("due_date"),
            "user_id" => $this->user()->id,
        ];
    }
}
