<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function save(array $data): User
    {
        $user = User::query()->create($data);

        return $user;
    }
}
