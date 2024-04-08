<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\User;
use Tests\Feature\BaseFeatureTestCase;

class ListBookTest extends BaseFeatureTestCase
{
    public function testListBooksWhenUnauthorized()
    {
        Book::factory()->create();

        $response = $this->get('/api/book');

        $response->assertUnauthorized();
    }

    public function testListBooksSuccessfully()
    {
        $user = User::factory()->create();

        $books = Book::factory(10)->create();

        $response = $this->actingAs($user)->get('/api/book');

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'isbn',
                    'value',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
        $this->assertCount($books->count(), $response->json()['data']);
    }

    public function testListBooksPaginationSuccessfully()
    {
        $user = User::factory()->create();

        Book::factory(20)->create();

        $response = $this->actingAs($user)->get('/api/book?per_page=10');

        $response->assertSuccessful();
        $this->assertCount(10, $response->json()['data']);
    }
}
