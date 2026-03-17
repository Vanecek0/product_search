<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Contracts\Cache\CacheInterface;

class ProductService
{
    public function __construct(private CacheInterface $cache, private ProductRepository $productRepository) {}

    public function getProduct(int $id): array
    {
        $product = $this->cache->get(
            "product_$id",
            fn(): array => $this->productRepository->findById($id)
        );

        $counter = $this->cache->get(
            "product_views_$id",
            static fn(): int => 0
        );

        $counter++;

        $this->cache->delete("product_views_$id");
        $this->cache->get("product_views_$id", static fn(): int => $counter);

        return $product;
    }

    public function getRequestCounter($id): int
    {
        return $this->cache->get("product_views_$id", static fn(): int => 0);
    }
}
