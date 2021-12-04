<?php

declare(strict_types=1);

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $user_id
 */
class AddRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "user_id" => ["required", "exists:users,id"],
        ];
    }
}
