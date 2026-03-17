<?php

declare(strict_types=1);

namespace App\Driver;

use Override;

class MySQLDriver implements ProductDriverInterface
{
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
