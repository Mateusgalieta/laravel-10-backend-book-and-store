<?php

namespace App\Domain\Book;

use App\Models\Book;

interface UpdateBook
{
    public function handle(): Book;
}
