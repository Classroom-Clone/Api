<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tests\Traits\ManagesUsers;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use ManagesUsers;

    public function testUserCanLoginWithProperCredentials(): void
    {
        $email = "test@example.com";

        $this->createUser([
            "email" => $email,
        ]);

        $response = $this->post("auth/login", [
            "email" => $email,
            "password" => "secret123",
        ]);

        $response->assertSuccessful();
    }

    public function testUserCannotLoginWithWrongCredentials(): void
    {
        $email = "test@example.com";

        $this->createUser([
            "email" => $email,
        ]);

        $response = $this->post("auth/login", [
            "email" => $email,
            "password" => "wrong-password-123",
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors("email");
    }

    public function testUserCannotLoginIfHeDoesntExist(): void
    {
        $response = $this->post("auth/login", [
            "email" => "userwhodoesntexists@example.com",
            "password" => "secret123",
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors("email");
    }
}
