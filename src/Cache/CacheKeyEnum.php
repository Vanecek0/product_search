<?php

declare(strict_types=1);

namespace App\Cache;

use App\Utils\KeyEnumInterface;
use Override;

enum CacheKeyEnum: string implements KeyEnumInterface
{
    case PRODUCT = 'product';
    case PRODUCT_VIEW = 'product_views';

    #[Override]
    public function getValue(): string
    {
        return $this->value;
    }
}
