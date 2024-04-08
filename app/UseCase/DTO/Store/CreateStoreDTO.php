<?php

namespace App\UseCase\DTO\Store;

use App\UseCase\DTO\BaseDTO;

class CreateStoreDTO extends BaseDTO
{
    /**
     * Store Name
     */
    public string $name;

    /**
     * Store address
     */
    public string $address;

    /**
     * Store active
     */
    public bool $active;

    public function __construct(
        string $name,
        string $address,
        string $active,
    ) {
        $this->name = $name;
        $this->address = $address;
        $this->active = $active;
    }
}
