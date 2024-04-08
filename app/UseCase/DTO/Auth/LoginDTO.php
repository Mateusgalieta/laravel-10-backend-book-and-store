<?php

namespace App\UseCase\DTO\Auth;

use App\UseCase\DTO\BaseDTO;

class LoginDTO extends BaseDTO
{
    /**
     * User Email
     */
    public string $email;

    /**
     * User Password
     */
    public string $password;

    public function __construct(
        string $email,
        string $password,
    ) {
        $this->email = $email;
        $this->password = $password;
    }
}
