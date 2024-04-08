<?php

namespace App\Domain\Book;

use App\Models\Book;

interface GetBook
{
    public function handle(): ?Book;
}
