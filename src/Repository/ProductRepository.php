<?php

declare(strict_types=1);

namespace App\Repository;

use App\Driver\ProductDriverInterface;
use Override;

/**
 * Repository pro práci s produkty.
 *
 * Zprostředkovává přístup k datům produktu přes zvolený driver (v /config/services.yaml).
 * Implementuje RepositoryInterface společné rozhraní pro repozitáře.
 */
class ProductRepository implements RepositoryInterface
{
    /**
     * @param ProductDriverInterface $driver Driver.
     */
    public function __construct(
        private ProductDriverInterface $driver,
    ) {}

    /**
     * Najde produkt podle jeho id.
     *
     * Deleguje volání na zvolený driver.
     *
     * @param int $id id produktu
     * @return array<string,mixed> Asociativní pole s informacemi o produktu
     */
    #[Override]
    public function findById(int $id): array
    {
        return $this->driver->findById($id);
    }
}
