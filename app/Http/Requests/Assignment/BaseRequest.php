<?php

declare(strict_types=1);

namespace App\Http\Requests\Assignment;

use App\Models\Attachment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

abstract class BaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "title" => ["required", "min:3", "max:150"],
            "content" => ["nullable", "max:500"],
            "points" => ["nullable", "integer", "min:1", "max:100"],
            "due_date" => ["required", "date", "after:now"],
            "attachments" => ["nullable", "array"],
            "attachments.*" => ["exists:attachments,id"],
        ];
    }

    abstract public function getAssignmentData(): array;

    public function getAttachments(): Collection
    {
        $ids = $this->get("attachments", []);

        return Attachment::query()->find($ids);
    }
}
