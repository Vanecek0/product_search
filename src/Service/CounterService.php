<?php

declare(strict_types=1);

namespace App\Service;

use App\Cache\CacheKeyEnum;
use App\Cache\ProductCacheKeyDTO;
use App\Utils\KeyBuilder;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * Service pro práci s počtem zobrazení produktů.
 *
 * Používá cache (např. filesystem, Redis, ...) pro ukládání počtu zobrazení
 * jednotlivých produktů.
 */
class CounterService
{
    /**
     * @param CacheInterface $counterCache Cache pool určená pro počítadlo produktů
     */
    public function __construct(
        private CacheInterface $counterCache,
    ) {}

    /**
     * Zvýší počet zobrazení produktu o 1.
     * Je pouze dočasným řešením (pro malý traffic) jelikož neřeší race conditions. (později vyřeší např. Redis)
     * Pokud nastane chyba cache (např. nenajde soubor), vrátí hodnotu 1.
     *
     * @param int $id id produktu
     * @return int počet zobrazení produktu
     */
    public function increment(int $id): int
    {
        try {
            $dto = new ProductCacheKeyDTO($id);
            $key = KeyBuilder::buildKey(CacheKeyEnum::PRODUCT_VIEW, $dto);

            $current = $this->counterCache->get($key, static fn(): int => 0);
            $newValue = $current + 1;

            $this->counterCache->delete($key);
            return $this->counterCache->get($key, static fn(): int => $newValue);
        } catch (\Psr\Cache\InvalidArgumentException $e) {
            return 1;
        }
    }

    /**
     * Vrátí počet zobrazení produktu.
     *
     * Pokud nastane chyba cache (např. nenajde soubor), vrátí hodnotu 0.
     *
     * @param int $id id produktu
     * @return int počet zobrazení produktu
     */
    public function getCount(int $id): int
    {
        try {
            $dto = new ProductCacheKeyDTO($id);
            $key = KeyBuilder::buildKey(CacheKeyEnum::PRODUCT_VIEW, $dto);

            return $this->counterCache->get($key, static fn(): int => 0);
        } catch (\Psr\Cache\InvalidArgumentException $e) {
            return 0;
        }
    }
}
