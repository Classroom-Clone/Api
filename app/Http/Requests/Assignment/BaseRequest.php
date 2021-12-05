<?php

declare(strict_types=1);

namespace App\Http\Requests\Assignment;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "title" => ["required", "min:3", "max:150"],
            "content" => ["nullable", "max:500"],
            "points" => ["nullable", "integer", "min:1", "max:100"],
            "due_date" => ["required", "date", "after:now"],
        ];
    }

    abstract public function getAssignmentData(): array;
}
