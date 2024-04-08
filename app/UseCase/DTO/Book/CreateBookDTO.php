<?php

namespace App\UseCase\DTO\Book;

use App\UseCase\DTO\BaseDTO;

class CreateBookDTO extends BaseDTO
{
    /**
     * Book Name
     */
    public string $name;

    /**
     * Book ISBN
     */
    public int $isbn;

    /**
     * Book Value
     */
    public float $value;

    public function __construct(
        string $name,
        string $isbn,
        string $value,
    ) {
        $this->name = $name;
        $this->isbn = $isbn;
        $this->value = $value;
    }
}
