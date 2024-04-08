<?php

namespace App\Repositories\Interfaces;

interface AttachRepositoryInterface
{
    public function attach(int $bookId, int $storeId): void;
}
