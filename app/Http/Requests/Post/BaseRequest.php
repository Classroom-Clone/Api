<?php

declare(strict_types=1);

namespace App\Http\Requests\Post;

use App\Models\Attachment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

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
            "attachments" => ["nullable", "array"],
            "attachments.*" => ["exists:attachments,id"],
        ];
    }

    abstract public function getPostData(): array;

    public function getLinks(): Collection
    {
        return collect($this->get("links", []));
    }

    public function getAttachments(): Collection
    {
        $ids = $this->get("attachments", []);

        return Attachment::query()->find($ids);
    }
}
