<?php

declare(strict_types=1);

namespace App\Cache;

use App\Utils\KeyEnumInterface;
use Override;

/**
 * Enum pro cache klíče.
 * Slouží jako centrální místo pro definici všech klíčů.
 */
enum CacheKeyEnum: string implements KeyEnumInterface
{
    /** Klíč pro produkty */
    case PRODUCT = 'product';

    /** Klíč pro počítadlo zobrazení produktů */
    case PRODUCT_VIEW = 'product_views';

    /**
     * Vrací hodnotu klíče jako string.
     *
     * @return string Hodnota klíče
     */
    #[Override]
    public function getValue(): string
    {
        return $this->value;
    }
}
