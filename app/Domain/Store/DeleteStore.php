<?php

namespace App\Domain\Store;

interface DeleteStore
{
    public function handle(): void;
}
