<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\ManagesUsers;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use ManagesUsers;

    public function testUserCanGetHisInformation(): void
    {
        $email = "test@example.com";

        $user = $this->createUser([
            "email" => $email,
        ]);

        Sanctum::actingAs($user);

        $response = $this->get("/me");

        $response->assertOk();
        $response->assertJsonFragment([
            "email" => $email,
        ]);
    }

    public function testUserCannotGetHisInformationWhenUnauthenticated(): void
    {
        $response = $this->get("/me");

        $response->assertUnauthorized();
    }
}
