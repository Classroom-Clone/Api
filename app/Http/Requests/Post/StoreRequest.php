<?php

declare(strict_types=1);

namespace App\Http\Requests\Post;

class StoreRequest extends BaseRequest
{
    public function getPostData(): array
    {
        return [
            "title" => $this->get("title"),
            "content" => $this->get("content"),
            "user_id" => $this->user()->id,
        ];
    }
}
