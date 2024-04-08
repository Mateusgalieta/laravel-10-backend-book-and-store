<?php

namespace Tests\Feature\Store;

use App\Models\Store;
use App\Models\User;
use Tests\Feature\BaseFeatureTestCase;

class UpdateStoreTest extends BaseFeatureTestCase
{
    public function testUpdateStoreWhenUnauthorized()
    {
        $store = Store::factory()->create();

        $response = $this->putJson('/api/store/' . $store->id);

        $response->assertUnauthorized();
    }

    public function testUpdateStoreSuccessfully()
    {
        $user = User::factory()->create();
        $store = Store::factory()->create();

        $payload = [
            'name' => fake()->name(),
            'address' => fake()->name(),
            'active' => true,
        ];

        $response = $this->actingAs($user)->putJson("/api/store/$store->id", $payload);

        $response->assertSuccessful();

        $data = $response->json();

        $this->assertEquals($payload['name'], $data['name']);
        $this->assertEquals($payload['address'], $data['address']);
        $this->assertEquals($payload['active'], $data['active']);

        $this->assertDatabaseHas('stores', [
            'id' => $store->id,
            'name' => $payload['name'],
            'address' => $payload['address'],
            'active' => $payload['active'],
            'deleted_at' => null,
        ]);
    }

    public function testReturnErrorUpdateStoreNameWhenInvalidFormat()
    {
        $user = User::factory()->create();
        $store = Store::factory()->create();

        $payload = [
            'name' => true,
        ];

        $response = $this->actingAs($user)->putJson("/api/store/$store->id", $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'name' => ['The name field must be a string.'],
            ],
        ]);
    }

    public function testReturnErrorUpdateStoreAddressWhenInvalidFormat()
    {
        $user = User::factory()->create();
        $store = Store::factory()->create();

        $payload = [
            'address' => false,
        ];

        $response = $this->actingAs($user)->putJson("/api/store/$store->id", $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'address' => ['The address field must be a string.'],
            ],
        ]);
    }

    public function testReturnErrorUpdateStoreActiveWhenInvalidFormat()
    {
        $user = User::factory()->create();
        $store = Store::factory()->create();

        $payload = [
            'active' => [],
        ];

        $response = $this->actingAs($user)->putJson("/api/store/$store->id", $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'active' => ['The active field must be true or false.'],
            ],
        ]);
    }
}
