<?php

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
        $dto = new ProductCacheKeyDTO($id);
        $key = KeyBuilder::buildKey(CacheKeyEnum::PRODUCT, $dto);

        $product = $this->productCache->get($key, fn(): array => $this->productRepository->findById($id));

        $this->counterService->increment($id);
        return $product;
    }
}
