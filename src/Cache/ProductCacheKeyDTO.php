<?php

declare(strict_types=1);

namespace App\Cache;

use App\Utils\ToArrayInterface;
use Override;

/**
 * DTO pro vytváření parametrů cache klíče pro konkrétní produkt.
 * Implementuje ToArrayInterface, pro snadné předání do KeyBuilderu.
 */
class ProductCacheKeyDTO implements ToArrayInterface
{
    public function __construct(
        private int $id,
    ) {}

    /**
     * Vrací parametry jako pole.
     *
     * @return array<string>
     */
    #[Override]
    public function toArray(): array
    {
        return [(string) $this->id];
    }
}
