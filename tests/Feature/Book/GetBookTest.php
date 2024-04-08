<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\User;
use Tests\Feature\BaseFeatureTestCase;

class GetBookTest extends BaseFeatureTestCase
{
    public function testGetBookWhenUnauthorized()
    {
        $book = Book::factory()->create();

        $response = $this->get('/api/book/' . $book->id);

        $response->assertUnauthorized();
    }

    public function testGetBookSuccessfully()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->get('/api/book/' . $book->id);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'id',
            'name',
            'isbn',
            'value',
            'created_at',
            'updated_at',
        ]);
    }

    public function testGetBookWhenNotFound()
    {
        $user = User::factory()->create();

        $id = fake()->randomDigitNotNull();

        $response = $this->actingAs($user)->get('/api/book/' . $id);

        $response->assertNotFound();
        $response->assertJson([
            'message' => "Book with ID $id was not found.",
        ]);
    }
}
