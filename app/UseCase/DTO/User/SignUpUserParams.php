<?php

namespace App\UseCase\DTO\User;

use App\UseCase\DTO\BaseDTO;

class SignUpUserParams extends BaseDTO
{
    /**
     * User Name
     */
    public string $name;

    /**
     * User Email
     */
    public string $email;

    /**
     * User Password
     */
    public string $password;

    public function __construct(
        string $name,
        string $email,
        string $password,
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
}
