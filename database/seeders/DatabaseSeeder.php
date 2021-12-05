<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create(
            [
                "email" => "admin@example.com",
            ],
        );

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

        Post::factory()
            ->forRandomClassroom()
            ->count(50)
            ->hasComments(Comment::factory()->count(10)->forRandomUser())
            ->hasLinks(3)
            ->create();

        Assignment::factory()
            ->forRandomClassroom()
            ->count(20)
            ->create();
    }
}
