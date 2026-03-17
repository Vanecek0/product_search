<?php

declare(strict_types=1);

namespace App\Driver;

/**
 * Rozhraní pro všechny drivery.
 *
 * Implementace tohoto rozhraní umožňuje zaměnitelně používat různé zdroje dat
 * (např. MySQL, ElasticSearch)
 */
interface ProductDriverInterface
{
    /**
     * Najde produkt podle jeho id.
     *
     * @param int $id id produktu
     * @return array<string,mixed> Asociativní pole s informacemi o produktu
     */
    public function findById(int $id): array;
}
