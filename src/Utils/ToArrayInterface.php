<?php

declare(strict_types=1);

namespace App\Utils;

/**
 * Rozhraní pro DTO/objekty, které lze převést na pole parametrů.
 */
interface ToArrayInterface
{
    /**
     * Vrátí data DTO jako pole.
     *
     * @return array
     */
    public function toArray(): array;
}
