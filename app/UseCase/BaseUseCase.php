<?php

namespace App\UseCase;

use App\Traits\Instancer;

abstract class BaseUseCase
{
    use Instancer;

    /**
     * Get Class Property
     */
    public function __get(string $property): mixed
    {
        return $this->{$property};
    }
}
