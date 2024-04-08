<?php

namespace App\Traits;

trait Instancer
{
    /**
     * Method to create new instance of class
     *
     * @param  mixed  ...$parameters
     */
    public function instance(string $className, ...$parameters): mixed
    {
        return new $className(...$parameters);
    }
}
