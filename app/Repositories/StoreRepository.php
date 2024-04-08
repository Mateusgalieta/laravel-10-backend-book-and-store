<?php

namespace App\Repositories;

use App\Models\Store;
use App\Repositories\Interfaces\StoreRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class StoreRepository implements StoreRepositoryInterface
{
    public function create(array $data): Store
    {
        $Store = Store::query()->create($data);

        return $Store;
    }

    public function listAll(int $perPage, int $page): LengthAwarePaginator
    {
        return Store::query()
            ->paginate(
                perPage: $perPage,
                page: $page
            );
    }

    public function findById(int $id): ?Store
    {
        $Store = Store::query()->find($id);

        return $Store;
    }

    public function updateById(int $id, array $data): Store
    {
        $Store = Store::query()->find($id);

        $Store->update($data);

        return $Store;
    }

    public function deleteById(int $id): void
    {
        Store::query()->find($id)->delete();
    }
}
