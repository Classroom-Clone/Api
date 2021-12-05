<?php

declare(strict_types=1);

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
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

    abstract public function getPostData(): array;

    public function getLinks(): array
    {
        return $this->get("links", []);
    }
}
