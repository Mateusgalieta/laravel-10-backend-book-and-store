<?php

namespace App\UseCase\DTO;

abstract class BaseDTO
{
    /**
     * Properties Array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
