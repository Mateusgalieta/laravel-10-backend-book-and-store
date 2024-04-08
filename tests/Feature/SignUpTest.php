<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;

class SignUpTest extends BaseFeatureTestCase
{
    public function testSignUpUserSuccessfully()
    {
        $payload = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => Str::random(8),
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertSuccessful();
        $response->assertJson([
            'success' => true,
            'message' => 'User registered successfully',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'deleted_at' => null,
        ]);
    }

    public function testReturnErrorWhenNotSentNameField()
    {
        $payload = [
            'email' => fake()->email(),
            'password' => Str::random(8),
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'status' => false,
            'errors' => [
                'name' => [
                    'The name field is required.',
                ],
            ],
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => $payload['email'],
        ]);
    }

    public function testReturnErrorWhenNameIsInvalidFormat()
    {
        $payload = [
            'name' => false,
            'email' => fake()->email(),
            'password' => Str::random(8),
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'status' => false,
            'errors' => [
                'name' => [
                    'The name field must be a string.',
                ],
            ],
        ]);

        $this->assertDatabaseMissing('users', [
            'name' => $payload['name'],
            'email' => $payload['email'],
        ]);
    }

    public function testReturnErrorWhenNotSentEmailField()
    {
        $payload = [
            'name' => fake()->name(),
            'password' => Str::random(8),
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'status' => false,
            'errors' => [
                'email' => [
                    'The email field is required.',
                ],
            ],
        ]);

        $this->assertDatabaseMissing('users', [
            'name' => $payload['name'],
        ]);
    }

    public function testReturnErrorWhenEmailIsInvalidFormat()
    {
        $payload = [
            'name' => fake()->name(),
            'email' => false,
            'password' => Str::random(8),
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'status' => false,
            'errors' => [
                'email' => [
                    'The email field must be a valid email address.',
                ],
            ],
        ]);

        $this->assertDatabaseMissing('users', [
            'name' => $payload['name'],
            'email' => $payload['email'],
        ]);
    }

    public function testReturnErrorWhenEmailAlreadyExists()
    {
        $payload = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => Str::random(8),
        ];

        User::factory()->create([
            'email' => $payload['email'],
        ]);

        $response = $this->postJson('/api/register', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'status' => false,
            'errors' => [
                'email' => [
                    'The email has already been taken.',
                ],
            ],
        ]);

        $this->assertDatabaseMissing('users', [
            'name' => $payload['name'],
            'email' => $payload['email'],
        ]);
    }

    public function testReturnErrorWhenNotSentPasswordField()
    {
        $payload = [
            'name' => fake()->name(),
            'email' => fake()->email(),
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'status' => false,
            'errors' => [
                'password' => [
                    'The password field is required.',
                ],
            ],
        ]);

        $this->assertDatabaseMissing('users', [
            'name' => $payload['name'],
            'email' => $payload['email'],
        ]);
    }

    public function testReturnErrorWhenPasswordIsInvalidFormat()
    {
        $payload = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => false,
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'status' => false,
            'errors' => [
                'password' => [
                    'The password field must be a string.',
                ],
            ],
        ]);

        $this->assertDatabaseMissing('users', [
            'name' => $payload['name'],
            'email' => $payload['email'],
        ]);
    }

    public function testReturnErrorWhenPasswordHaventMinLength()
    {
        $payload = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => Str::random(6),
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'status' => false,
            'errors' => [
                'password' => [
                    'The password field must be at least 8 characters.',
                ],
            ],
        ]);

        $this->assertDatabaseMissing('users', [
            'name' => $payload['name'],
            'email' => $payload['email'],
        ]);
    }

    public function testReturnErrorWhenPasswordHaventMaxLength()
    {
        $payload = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => Str::random(257),
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'status' => false,
            'errors' => [
                'password' => [
                    'The password field must not be greater than 256 characters.',
                ],
            ],
        ]);

        $this->assertDatabaseMissing('users', [
            'name' => $payload['name'],
            'email' => $payload['email'],
        ]);
    }
}
