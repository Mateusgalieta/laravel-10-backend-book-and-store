<?php

namespace Tests\Feature\Store;

use App\Models\Store;
use App\Models\User;
use Tests\Feature\BaseFeatureTestCase;

class DeleteStoreTest extends BaseFeatureTestCase
{
    public function testDeleteStoreWhenUnauthorized()
    {
        $store = Store::factory()->create();

        $response = $this->delete("/api/store/$store->id");

        $response->assertUnauthorized();
    }

    public function testDeleteStoreSuccessfully()
    {
        $user = User::factory()->create();
        $store = Store::factory()->create();

        $response = $this->actingAs($user)->delete("/api/store/$store->id");

        $response->assertSuccessful();
        $response->assertJson([
            'message' => "Store with ID $store->id deleted successfully.",
        ]);

        $this->assertDatabaseMissing('stores', [
            'name' => $store->name,
            'address' => $store->address,
            'active' => $store->active,
            'deleted_at' => null,
        ]);
    }

    public function testDeleteStoreFailed()
    {
        $user = User::factory()->create();

        $id = fake()->randomDigitNotNull();

        $response = $this->actingAs($user)->delete("/api/store/$id");

        $response->assertBadRequest();
    }
}
