<?php

namespace App\Repositories\Interfaces;

use App\Models\Store;
use Illuminate\Pagination\LengthAwarePaginator;

interface StoreRepositoryInterface
{
    public function create(array $data): Store;

    public function listAll(int $perPage, int $page): LengthAwarePaginator;

    public function findById(int $id): ?Store;

    public function updateById(int $id, array $data): Store;

    public function deleteById(int $id): void;
}
