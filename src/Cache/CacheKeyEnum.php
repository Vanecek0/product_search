<?php

namespace App\Cache;

use App\Utils\KeyEnumInterface;

enum CacheKeyEnum: string implements KeyEnumInterface
{
    case PRODUCT = 'product';
    case PRODUCT_VIEW = 'product_views';

    public function getValue(): string
    {
        return $this->value;
    }
}
