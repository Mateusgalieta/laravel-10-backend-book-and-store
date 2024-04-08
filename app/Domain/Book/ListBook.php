<?php

namespace App\Domain\Book;

use Illuminate\Pagination\LengthAwarePaginator;

interface ListBook
{
    public function handle(): LengthAwarePaginator;
}
