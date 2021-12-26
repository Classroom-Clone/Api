<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tests\Traits\ManagesUsers;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    use ManagesUsers;

    public function testUserCanRegisterWithProperCredentials(): void
    {
        $response = $this->post("auth/register", [
            "email" => "test@example.com",
            "first_name" => "Test",
            "last_name" => "User",
            "password" => "secret123",
            "password_confirmation" => "secret123",
        ]);

        $response->assertSuccessful();
    }

    public function testUserCannotRegisterWithoutFirstNameProperty(): void
    {
        $response = $this->post("auth/register", [
            "last_name" => "User",
            "email" => "test@example.com",
            "password" => "secret123",
            "password_confirmation" => "secret123",
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors("first_name");
    }

    public function testUserCannotRegisterUsingExistingEmail(): void
    {
        $email = "test@example.com";

        $this->createUser([
            "email" => $email,
        ]);

        $response = $this->post("auth/register", [
            "email" => $email,
            "first_name" => "Test",
            "last_name" => "User",
            "password" => "secret123",
            "password_confirmation" => "secret123",
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors("email");
    }

    public function testUserCannotRegisterWithoutPasswordConfirmation(): void
    {
        $response = $this->post("auth/register", [
            "email" => "test@example.com",
            "first_name" => "Test",
            "last_name" => "User",
            "password" => "secret123",
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["password", "password_confirmation"]);
    }
}
