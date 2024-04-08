<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Store;
use App\Models\User;

class DetachTest extends BaseFeatureTestCase
{
    public function testUnlinkBookAndStoreSuccessfully()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $store = Store::factory()->create();

        $payload = [
            'book_id' => $book->id,
            'store_id' => $store->id,
        ];

        $response = $this->actingAs($user)->postJson('/api/book/store/detach', $payload);

        $response->assertSuccessful();
        $response->assertCreated();

        $this->assertDatabaseMissing('book_store', [
            'book_id' => $payload['book_id'],
            'store_id' => $payload['store_id'],
        ]);
    }
}
