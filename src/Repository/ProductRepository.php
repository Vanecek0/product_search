<?php

declare(strict_types=1);

namespace App\Repository;

use App\Driver\ProductDriverInterface;
use Override;

class ProductRepository implements RepositoryInterface
{
    public function __construct(
        private ProductDriverInterface $driver,
    ) {}

    #[Override]
    public function findById(int $id): array
    {
        return $this->driver->findById($id);
    }
}
