<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->create([
                "email" => "admin@example.com",
            ]);

        Classroom::factory()
            ->count(8)
            ->hasOwner()
            ->hasMembers(20)
            ->create();

        Classroom::factory()
            ->count(2)
            ->archived()
            ->hasOwner()
            ->hasMembers(20)
            ->create();
    }
}
