<?php

declare(strict_types=1);

namespace App\Http\Requests\Classroom;

use App\Rules\Hex;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property string $description
 * @property string $accent_color
 */
class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required", "min:3", "max:150"],
            "description" => ["nullable", "max:500"],
            "accent_color" => ["required", new Hex()],
        ];
    }
}
