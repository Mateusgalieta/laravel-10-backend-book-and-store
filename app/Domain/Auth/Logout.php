<?php

namespace App\Domain\Auth;

interface Logout
{
    public function handle(): void;
}
