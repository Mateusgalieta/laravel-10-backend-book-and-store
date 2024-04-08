<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface StoreRepositoryInterface
{
    public function signUp(array $data): User;
}
