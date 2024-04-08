<?php

namespace App\Domain\Auth;

interface Login
{
    public function handle(): string;
}
