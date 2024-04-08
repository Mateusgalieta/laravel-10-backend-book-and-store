<?php

namespace App\Domain\Store;

use App\Models\Store;

interface GetStore
{
    public function handle(): ?Store;
}
