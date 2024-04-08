<?php

namespace App\Domain\Book;

use App\Models\Book;

interface CreateBook
{
    public function handle(): Book;
}
