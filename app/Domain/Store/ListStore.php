<?php

namespace App\Domain\Store;

use Illuminate\Pagination\LengthAwarePaginator;

interface ListStore
{
    public function handle(): LengthAwarePaginator;
}
