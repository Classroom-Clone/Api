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
            ->count(50)
            ->create();

        Classroom::factory()
            ->count(8)
            ->hasRandomOwner()
            ->create();

        Classroom::factory()
            ->count(2)
            ->archived()
            ->hasRandomOwner()
            ->create();
    }
}
