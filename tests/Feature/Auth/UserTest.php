<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CreatesUsers;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;

    public function testUserCanGetHisInformation(): void
    {
        $email = "test@example.com";

        $user = $this->createUser($email);

        Sanctum::actingAs($user);

        $response = $this->get("auth/user");

        $response->assertOk();
        $response->assertJsonFragment([
            "email" => $email,
        ]);
    }

    public function testUserCannotGetHisInformationWhenUnauthenticated(): void
    {
        $response = $this->get("auth/user");

        $response->assertUnauthorized();
    }
}
