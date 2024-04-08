<?php

namespace App\Domain\Store;

use App\Models\Store;

interface CreateStore
{
    public function handle(): Store;
}
