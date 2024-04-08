<?php

namespace Tests\Feature\Store;

use App\Models\Store;
use App\Models\User;
use Tests\Feature\BaseFeatureTestCase;

class ListStoreTest extends BaseFeatureTestCase
{
    public function testListStoresWhenUnauthorized()
    {
        Store::factory()->create();

        $response = $this->get('/api/store');

        $response->assertUnauthorized();
    }

    public function testListStoresSuccessfully()
    {
        $user = User::factory()->create();

        $Stores = Store::factory(10)->create();

        $response = $this->actingAs($user)->get('/api/store');

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'address',
                    'active',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
        $this->assertCount($Stores->count(), $response->json()['data']);
    }

    public function testListStoresPaginationSuccessfully()
    {
        $user = User::factory()->create();

        Store::factory(20)->create();

        $response = $this->actingAs($user)->get('/api/store?per_page=10');

        $response->assertSuccessful();
        $this->assertCount(10, $response->json()['data']);
    }
}
