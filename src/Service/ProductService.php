<?php

declare(strict_types=1);

namespace App\Service;

use App\Cache\CacheKeyEnum;
use App\Cache\ProductCacheKeyDTO;
use App\Repository\ProductRepository;
use App\Utils\KeyBuilder;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * Service pro práci s produkty.
 *
 * Obsahuje metodu pro načtení produktu z cache nebo db a zároveň inkrementuje
 * počet jeho zobrazení přes CounterService.
 *
 * Používá cache (např. filesystem, Redis).
 * Pokud dojde k chybě s cache, vrátí produkt pomocí repository (z db).
 * Pokud jde o první nalezení, uloží produkt do cache a vrátí jej.
 */
class ProductService
{
    /**
     * @param CacheInterface $productCache Cache pool pro caching produktů
     * @param CounterService $counterService Service pro počítání zobrazení produktů
     * @param ProductRepository $productRepository Repository pro práci s produkty
     */
    public function __construct(
        private CacheInterface $productCache,
        private CounterService $counterService,
        private ProductRepository $productRepository,
    ) {}

    /**
     * Načte produkt podle id.
     *
     * Pokusí se načíst produkt z cache. Pokud cache selže, načte produkt
     * přímo z repository. Po každém načtení se automaticky zvýší
     * počet zobrazení produktu v CounterService.
     *
     * @param int $id id produktu
     * @return array Asociativní pole s informacemi o produktu
     */
    public function findProductById(int $id): array
    {
        try {
            $dto = new ProductCacheKeyDTO($id);
            $key = KeyBuilder::buildKey(CacheKeyEnum::PRODUCT, $dto);

            return $this->productCache->get($key, fn(): array => $this->productRepository->findById($id));
        } catch (\Psr\Cache\InvalidArgumentException $e) {
            return $this->productRepository->findById($id);
        } finally {
            $this->counterService->increment($id);
        }
    }
}
