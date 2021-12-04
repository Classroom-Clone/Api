<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\User;
use Illuminate\Support\Collection;

trait ManagesUsers
{
    public function createUser(array $data = []): User
    {
        /** @var User $user */
        $user = User::factory($data)->create();

        return $user;
    }

    public function createUsers(int $count = 5): Collection
    {
        return User::factory()
            ->count($count)
            ->create();
    }
}
