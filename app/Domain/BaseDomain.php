<?php

namespace App\Domains;

use App\Traits\Instancer;

abstract class BaseDomain
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
