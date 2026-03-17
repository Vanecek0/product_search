<?php

declare(strict_types=1);

namespace App\Cache;

use App\Utils\ToArrayInterface;
use Override;

class ProductCacheKeyDTO implements ToArrayInterface
{
    public function __construct(
        private int $id,
    ) {}

    #[Override]
    public function toArray(): array
    {
        return [$this->id];
    }
}
