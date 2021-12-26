<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Hex implements Rule
{
    public function passes($attribute, $value): bool
    {
        $pattern = "/#[0-9A-Fa-f]{6}\b/";

        return (bool)preg_match($pattern, $value);
    }

    public function message(): string
    {
        return "The hex code is not valid";
    }
}
