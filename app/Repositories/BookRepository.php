<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BookRepository implements BookRepositoryInterface
{
    public function create(array $data): Book
    {
        $book = Book::query()->create($data);

        return $book;
    }

    public function listAll(int $perPage, int $page): LengthAwarePaginator
    {
        return Book::query()
            ->paginate(
                perPage: $perPage,
                page: $page
            );
    }

    public function findById(int $id): ?Book
    {
        $book = Book::query()->find($id);

        return $book;
    }

    public function updateById(int $id, array $data): Book
    {
        $book = Book::query()->find($id);

        $book->update($data);

        return $book;
    }

    public function deleteById(int $id): void
    {
        Book::query()->find($id)->delete();
    }
}
