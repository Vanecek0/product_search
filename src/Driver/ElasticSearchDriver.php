<?php

declare(strict_types=1);

namespace App\Driver;

use Override;

/**
 * Driver pro získávání produktů z ElasticSearch.
 *
 * Implementuje rozhraní ProductDriverInterface a poskytuje metody pro
 * vyhledávání produktů v ElasticSearch. Aktuálně obsahuje mock data.
 */
class ElasticSearchDriver implements ProductDriverInterface
{
    /**
     * Najde produkt podle id.
     *
     * @param int $id id produktu - Upraven datový typ na int (v případě id produktu dává smysl)
     * @todo v pozdější fázi vývoje vytvořit DTO pro produkt
     * @return array<string,mixed> Asociativní pole s informacemi o produktu
     */
    #[Override]
    public function findById(int $id): array
    {
        return [
            'id' => 1,
            'name' => 'Wireless Mouse',
            'description' => 'Ergonomic wireless mouse with USB receiver',
            'price' => 29.99,
            'currency' => 'USD',
            'in_stock' => true,
            'stock_quantity' => 42,
            'category' => 'Electronics',
            'sku' => 'MOUSE-001',
            'created_at' => '2026-03-16 12:00:00',
        ];
    }
}
