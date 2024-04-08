<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\User;
use Tests\Feature\BaseFeatureTestCase;

class UpdateBookTest extends BaseFeatureTestCase
{
    public function testUpdateBookWhenUnauthorized()
    {
        $book = Book::factory()->create();

        $response = $this->putJson('/api/book/' . $book->id);

        $response->assertUnauthorized();
    }

    public function testUpdateBookSuccessfully()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $payload = [
            'name' => fake()->name(),
            'isbn' => fake()->randomDigitNotNull(),
            'value' => 12.30,
        ];

        $response = $this->actingAs($user)->putJson("/api/book/$book->id", $payload);

        $response->assertSuccessful();

        $data = $response->json();

        $this->assertEquals($payload['name'], $data['name']);
        $this->assertEquals($payload['isbn'], $data['isbn']);
        $this->assertEquals($payload['value'], $data['value']);
    }

    public function testReturnErrorUpdateBookNameWhenInvalidFormat()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $payload = [
            'name' => true,
        ];

        $response = $this->actingAs($user)->putJson("/api/book/$book->id", $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'name' => ['The name field must be a string.'],
            ],
        ]);
    }

    public function testReturnErrorUpdateBookISBNWhenInvalidFormat()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $payload = [
            'isbn' => fake()->name(),
        ];

        $response = $this->actingAs($user)->putJson("/api/book/$book->id", $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'isbn' => ['The isbn field must be an integer.'],
            ],
        ]);
    }

    public function testReturnErrorUpdateBookISBNWhenAlreadyExists()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $isbn = fake()->randomDigitNotNull();
        Book::factory()->create([
            'isbn' => $isbn,
        ]);

        $payload = [
            'isbn' => $isbn,
        ];

        $response = $this->actingAs($user)->putJson("/api/book/$book->id", $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'isbn' => ['The isbn has already been taken.'],
            ],
        ]);
    }

    public function testReturnErrorUpdateBookValueWhenInvalidFormat()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $payload = [
            'value' => [],
        ];

        $response = $this->actingAs($user)->putJson("/api/book/$book->id", $payload);

        $response->assertUnprocessable();
        $response->assertJson([
            'errors' => [
                'value' => ['The value field must be a number.'],
            ],
        ]);
    }
}
