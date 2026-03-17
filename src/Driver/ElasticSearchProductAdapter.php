<?php

namespace App\Driver;

class ElasticSearchProductAdapter implements ProductDriverInterface
{
    public function __construct(private ElasticSearchDriverInterface $driver) {}
    public function findById(string $id): array
    {
        return $this->driver->findById($id);
    }
}
