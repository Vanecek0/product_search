<?php

namespace App\Service;

use App\Cache\CacheKeyEnum;
use App\Cache\ProductCacheKeyDTO;
use App\Utils\KeyBuilder;
use Symfony\Contracts\Cache\CacheInterface;

class CounterService
{
    public function __construct(
        private CacheInterface $counterCache,
    ) {}

    public function increment(int $id): int
    {
        $dto = new ProductCacheKeyDTO($id);
        $key = KeyBuilder::buildKey(CacheKeyEnum::PRODUCT_VIEW, $dto);

        $current = $this->counterCache->get($key, static fn(): int => 0);

        $newValue = $current + 1;

        $this->counterCache->delete($key);

        return $this->counterCache->get($key, fn(): int => $newValue);
    }

    public function getCount($id): int
    {
        $dto = new ProductCacheKeyDTO($id);
        $key = KeyBuilder::buildKey(CacheKeyEnum::PRODUCT_VIEW, $dto);
        return $this->counterCache->get($key, static fn(): int => 0);
    }
}
