<?php

namespace App\Repositories\Interfaces;

interface DetachRepositoryInterface
{
    public function detach(int $bookId, int $storeId): void;
}
