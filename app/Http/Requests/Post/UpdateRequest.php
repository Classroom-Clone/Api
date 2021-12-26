<?php

declare(strict_types=1);

namespace App\Http\Requests\Post;

class UpdateRequest extends BaseRequest
{
    public function getPostData(): array
    {
        return [
            "title" => $this->get("title"),
            "content" => $this->get("content"),
        ];
    }
}
