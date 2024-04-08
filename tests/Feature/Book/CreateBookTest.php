<?php

namespace Tests\Feature\Book;

use App\Models\User;
use Tests\Feature\BaseFeatureTestCase;

class CreateBookTest extends BaseFeatureTestCase
{
    public function testCreateBookSuccessfully()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => fake()->name(),
            'isbn' => fake()->randomDigitNotNull(),
            'value' => 15.15,
        ];

        $response = $this->actingAs($user)->postJson('/api/book', $payload);

        $response->assertSuccessful();
        $response->assertCreated();
        $response->assertJsonStructure([
            'id',
            'name',
            'isbn',
            'value',
            'created_at',
            'updated_at',
        ]);
    }

    public function testReturnErrorCreateBookWhenUnauthorized()
    {
        $payload = [
            'name' => fake()->name(),
            'isbn' => fake()->randomDigitNotNull(),
            'value' => 15.15,
        ];

        $response = $this->postJson('/api/book', $payload);

        $response->assertUnauthorized();
    }

    public function testReturnErroWhenNameNotSent()
    {
        $user = User::factory()->create();

        $payload = [
            'isbn' => fake()->randomDigitNotNull(),
            'value' => 15.15,
        ];

        $response = $this->actingAs($user)->postJson('/api/book', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'name' => [
                    'The name field is required.',
                ],
            ],
        ]);
    }

    public function testReturnErroWhenNameInvalid()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => true,
            'isbn' => fake()->randomDigitNotNull(),
            'value' => 15.15,
        ];

        $response = $this->actingAs($user)->postJson('/api/book', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'name' => [
                    'The name field must be a string.',
                ],
            ],
        ]);
    }

    public function testReturnErroWhenIsbnNotSent()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => fake()->name(),
            'value' => 15.15,
        ];

        $response = $this->actingAs($user)->postJson('/api/book', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'isbn' => [
                    'The isbn field is required.',
                ],
            ],
        ]);
    }

    public function testReturnErroWhenIsbnInvalid()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => fake()->name(),
            'isbn' => false,
            'value' => 15.15,
        ];

        $response = $this->actingAs($user)->postJson('/api/book', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'isbn' => [
                    'The isbn field must be an integer.',
                ],
            ],
        ]);
    }

    public function testReturnErroWhenValueNotSent()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => fake()->name(),
            'isbn' => fake()->randomDigitNotNull(),
        ];

        $response = $this->actingAs($user)->postJson('/api/book', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'value' => [
                    'The value field is required.',
                ],
            ],
        ]);
    }

    public function testReturnErroWhenValueInvalid()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => fake()->name(),
            'isbn' => fake()->randomDigitNotNull(),
            'value' => true,
        ];

        $response = $this->actingAs($user)->postJson('/api/book', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'value' => [
                    'The value field must be a number.',
                ],
            ],
        ]);
    }
}
