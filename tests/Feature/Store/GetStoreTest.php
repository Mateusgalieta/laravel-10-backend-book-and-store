<?php

namespace Tests\Feature\Store;

use App\Models\Store;
use App\Models\User;
use Tests\Feature\BaseFeatureTestCase;

class GetStoreTest extends BaseFeatureTestCase
{
    public function testGetStoreWhenUnauthorized()
    {
        $store = Store::factory()->create();

        $response = $this->get('/api/store/' . $store->id);

        $response->assertUnauthorized();
    }

    public function testGetStoreSuccessfully()
    {
        $user = User::factory()->create();
        $store = Store::factory()->create();

        $response = $this->actingAs($user)->get('/api/store/' . $store->id);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'id',
            'name',
            'address',
            'active',
            'created_at',
            'updated_at',
        ]);
    }

    public function testGetStoreWhenNotFound()
    {
        $user = User::factory()->create();

        $id = fake()->randomDigitNotNull();

        $response = $this->actingAs($user)->get('/api/store/' . $id);

        $response->assertNotFound();
        $response->assertJson([
            'message' => "Store with ID $id was not found.",
        ]);
    }
}
