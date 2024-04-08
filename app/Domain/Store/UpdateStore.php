<?php

namespace App\Domain\Store;

use App\Models\Store;

interface UpdateStore
{
    public function handle(): Store;
}
