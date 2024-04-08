<?php

namespace App\Domain\Book;

use App\Models\Book;

interface Create
{
    public function handle(): Book;
}
