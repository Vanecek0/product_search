<?php

namespace App\Cache;

use ToArrayInterface;

class ProductCacheKeyDTO implements ToArrayInterface
{
    public function __construct(
        private int $productId,
    ) {}

    public function toArray(): array
    {
        return [(string) $this->productId];
    }
}
