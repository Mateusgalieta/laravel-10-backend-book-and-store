<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Interfaces\DetachRepositoryInterface;

class DetachRepository implements DetachRepositoryInterface
{
    public function detach(int $bookId, int $storeId): void
    {
        $book = Book::query()->find($bookId);

        // Inlink data on ternary table between Books and Stores (Many to Many)
        $book->stores()->detach($storeId);
    }
}
