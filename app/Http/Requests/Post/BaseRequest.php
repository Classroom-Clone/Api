<?php

declare(strict_types=1);

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "title" => ["required", "min:3", "max:150"],
            "content" => ["required", "max:500"],
            "links" => ["nullable", "array"],
            "links.*.name" => ["nullable", "min:3", "max:70"],
            "links.*.url" => ["required", "min:3", "max:255"],
        ];
    }

    public function getPostData(): array
    {
        return [
            "title" => $this->get("title"),
            "content" => $this->get("content"),
            "user_id" => $this->user()->id,
        ];
    }

    public function getLinks(): array
    {
        return $this->get("links", []);
    }
}
