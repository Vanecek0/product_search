<?php

namespace App\Driver;

interface MySQLDriverInterface
{
    public function findProduct(string $id): array;
}
