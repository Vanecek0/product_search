<?php

namespace App\Driver;

interface ProductDriverInterface
{
    public function findById(string $id): array;
}