<?php

namespace App\Driver;

class MySQLProductAdapter implements ProductDriverInterface
{
    public function __construct(private MySQLDriverInterface $driver) {}
    public function findById(string $id): array
    {
        return $this->driver->findProduct($id);
    }
}