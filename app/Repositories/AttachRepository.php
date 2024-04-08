<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Interfaces\AttachRepositoryInterface;

class AttachRepository implements AttachRepositoryInterface
{
    public function attach(int $bookId, int $storeId): void
    {
        $book = Book::query()->find($bookId);

        // Creating data on ternary table between Books and Stores (Many to Many)
        $book->stores()->attach($storeId);
    }
}
