<?php

declare(strict_types=1);

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
