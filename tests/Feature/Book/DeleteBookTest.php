<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\User;
use Tests\Feature\BaseFeatureTestCase;

class DeleteBookTest extends BaseFeatureTestCase
{
    public function testDeleteBookWhenUnauthorized()
    {
        $book = Book::factory()->create();

        $response = $this->delete("/api/book/$book->id");

        $response->assertUnauthorized();
    }

    public function testDeleteBookSuccessfully()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->delete("/api/book/$book->id");

        $response->assertSuccessful();
        $response->assertJson([
            'message' => "Book with ID $book->id deleted successfully.",
        ]);

        $this->assertDatabaseMissing('books', [
            'name' => $book->name,
            'isbn' => $book->isbn,
            'value' => $book->value,
            'deleted_at' => null,
        ]);
    }

    public function testDeleteBookFailed()
    {
        $user = User::factory()->create();

        $id = fake()->randomDigitNotNull();

        $response = $this->actingAs($user)->delete("/api/book/$id");

        $response->assertBadRequest();
    }
}
