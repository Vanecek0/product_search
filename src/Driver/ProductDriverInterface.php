<?php

declare(strict_types=1);

namespace App\Driver;

interface ProductDriverInterface
{
    public function findById(int $id): array;
}
