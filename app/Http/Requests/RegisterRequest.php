<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 */
class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "email" => ["required", "email", "unique:users,email"],
            "first_name" => ["required", "min:3"],
            "last_name" => ["required", "min:3"],
            "password" => ["required", "confirmed"],
            "password_confirmation" => ["required"],
        ];
    }
}
