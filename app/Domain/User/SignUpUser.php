<?php

namespace App\Domain\User;

use App\Models\User;

interface SignUpUser
{
    public function handle(): User;
}
