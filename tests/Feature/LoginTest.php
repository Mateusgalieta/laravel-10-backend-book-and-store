<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginTest extends BaseFeatureTestCase
{
    public function testLoginSuccessfully()
    {
        $password = Str::random(8);

        $user = User::factory()->create([
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'access_token',
        ]);
    }

    public function testReturnErrorLoginWhenNotSentEmailField()
    {
        $password = Str::random(8);

        $response = $this->post('/api/login', [
            'password' => $password,
        ]);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'email' => [
                    'The email field is required.',
                ],
            ],
        ]);
    }

    public function testReturnErrorLoginWhenSentEmailInvalid()
    {
        $password = Str::random(8);

        $response = $this->postJson('/api/login', [
            'email' => true,
            'password' => $password,
        ]);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'email' => [
                    'The email field must be a valid email address.',
                ],
            ],
        ]);
    }

    public function testReturnErrorLoginWhenNotSentPasswordField()
    {
        $response = $this->postJson('/api/login', [
            'email' => true,
        ]);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'password' => [
                    'The password field is required.',
                ],
            ],
        ]);
    }

    public function testReturnErrorLoginWhenPasswordIsInvalidFormat()
    {
        $payload = [
            'email' => fake()->email(),
            'password' => false,
        ];

        $response = $this->postJson('/api/login', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'status' => false,
            'errors' => [
                'password' => [
                    'The password field must be a string.',
                ],
            ],
        ]);
    }

    public function testReturnErrorLoginWhenPasswordHaventMinLength()
    {
        $payload = [
            'email' => fake()->email(),
            'password' => Str::random(6),
        ];

        $response = $this->postJson('/api/login', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'status' => false,
            'errors' => [
                'password' => [
                    'The password field must be at least 8 characters.',
                ],
            ],
        ]);
    }

    public function testReturnErrorLoginWhenPasswordHaventMaxLength()
    {
        $payload = [
            'email' => fake()->email(),
            'password' => Str::random(257),
        ];

        $response = $this->postJson('/api/login', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'status' => false,
            'errors' => [
                'password' => [
                    'The password field must not be greater than 256 characters.',
                ],
            ],
        ]);
    }
}
