<?php

declare(strict_types=1);

namespace App\Http\Requests\Comment;

class StoreRequest extends BaseRequest
{
    public function getCommentData(): array
    {
        return [
            "content" => $this->get("content"),
            "user_id" => $this->user()->id,
        ];
    }
}
