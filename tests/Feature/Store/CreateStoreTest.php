<?php

namespace Tests\Feature\Store;

use App\Models\User;
use Tests\Feature\BaseFeatureTestCase;

class CreateStoreTest extends BaseFeatureTestCase
{
    public function testCreateStoreSuccessfully()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => fake()->name(),
            'address' => fake()->name(),
            'active' => true,
        ];

        $response = $this->actingAs($user)->postJson('/api/store', $payload);

        $response->assertSuccessful();
        $response->assertCreated();
        $response->assertJsonStructure([
            'id',
            'name',
            'address',
            'active',
            'created_at',
            'updated_at',
        ]);

        $this->assertDatabaseHas('stores', [
            'name' => $payload['name'],
            'address' => $payload['address'],
            'active' => $payload['active'],
            'deleted_at' => null,
        ]);
    }

    public function testReturnErrorCreateStoreWhenUnauthorized()
    {
        $payload = [
            'name' => fake()->name(),
            'address' => fake()->name(),
            'active' => true,
        ];

        $response = $this->postJson('/api/store', $payload);

        $response->assertUnauthorized();
    }

    public function testReturnErroWhenNameNotSent()
    {
        $user = User::factory()->create();

        $payload = [
            'address' => fake()->randomDigitNotNull(),
            'active' => true,
        ];

        $response = $this->actingAs($user)->postJson('/api/store', $payload);

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
            'address' => fake()->name(),
            'active' => true,
        ];

        $response = $this->actingAs($user)->postJson('/api/store', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'name' => [
                    'The name field must be a string.',
                ],
            ],
        ]);
    }

    public function testReturnErroWhenAddressNotSent()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => fake()->name(),
            'active' => true,
        ];

        $response = $this->actingAs($user)->postJson('/api/store', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'address' => [
                    'The address field is required.',
                ],
            ],
        ]);
    }

    public function testReturnErroWhenAddressInvalid()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => fake()->name(),
            'address' => false,
            'active' => true,
        ];

        $response = $this->actingAs($user)->postJson('/api/store', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'address' => [
                    'The address field must be a string.',
                ],
            ],
        ]);
    }

    public function testReturnErroWhenActiveNotSent()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => fake()->name(),
            'address' => fake()->name(),
        ];

        $response = $this->actingAs($user)->postJson('/api/store', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'active' => [
                    'The active field is required.',
                ],
            ],
        ]);
    }

    public function testReturnErroWhenActiveInvalid()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => fake()->name(),
            'address' => fake()->name(),
            'active' => fake()->name(),
        ];

        $response = $this->actingAs($user)->postJson('/api/store', $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'active' => [
                    'The active field must be true or false.',
                ],
            ],
        ]);
    }
}
