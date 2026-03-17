<?php

declare(strict_types=1);

namespace App\Service;

use App\Cache\CacheKeyEnum;
use App\Cache\ProductCacheKeyDTO;
use App\Repository\ProductRepository;
use App\Utils\KeyBuilder;
use Symfony\Contracts\Cache\CacheInterface;

class ProductService
{
    public function __construct(
        private CacheInterface $productCache,
        private CounterService $counterService,
        private ProductRepository $productRepository,
    ) {}

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
