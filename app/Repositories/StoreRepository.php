<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\StoreRepositoryInterface;

class StoreRepository implements StoreRepositoryInterface
{
    public function signUp(array $data): User
    {
        $user = User::create($data);

        return $user;
    }
}
