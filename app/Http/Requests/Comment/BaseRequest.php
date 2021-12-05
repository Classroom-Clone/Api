<?php

declare(strict_types=1);

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "content" => ["required", "max:500"],
        ];
    }

    abstract public function getCommentData(): array;
}
