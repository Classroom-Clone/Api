<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait CreatesUsers
{
    public function createUser(string $email = "test@example.com", string $password = "secret123"): User
    {
        /** @var User $user */
        $user = User::factory([
            "email" => $email,
            "password" => Hash::make($password),
        ])->create();

        return $user;
    }
}
