<?php

namespace App\Repositories\Interfaces;

use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;

interface BookRepositoryInterface
{
    public function create(array $data): Book;

    public function listAll(int $perPage, int $page): LengthAwarePaginator;

    public function findById(int $id): ?Book;

    public function updateById(int $id, array $data): Book;

    public function deleteById(int $id): void;
}
