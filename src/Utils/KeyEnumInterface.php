<?php

declare(strict_types=1);

namespace App\Utils;

/**
 * Rozhraní pro enums, které lze použít jako klíče.
 */
interface KeyEnumInterface
{
    /**
     * Vrátí hodnotu klíče jako string.
     *
     * @return string
     */
    public function getValue(): string;
}
