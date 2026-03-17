<?php

namespace App\Repository;

use App\Driver\ProductDriverInterface;

class ProductRepository implements RepositoryInterface
{
    public function __construct(
        private ProductDriverInterface $driver,
    ) {}

    public function findById(string $id): array
    {
        $data = $this->driver->findById($id);
        return $data;
    }
}
