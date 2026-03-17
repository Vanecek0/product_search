<?php

declare(strict_types=1);

namespace App\Utils;

/**
 * Builder např. cache klíčů.
 * Implementuje ToArrayInterface.
 *
 * Slouží k jednotnému generování string klíčů
 * nebo jiné storage systémy, kde potřebujeme jednoznačný klíč.
 */
class KeyBuilder
{
    /**
     * Vytvoří klíč ve formátu: "{key}_{param1}_{param2}_..."
     *
     * Pokud DTO nemá žádné parametry, vrací pouze hodnotu enumu.
     *
     * @param KeyEnumInterface $key Enum definující typ klíče (např. PRODUCT)
     * @param ToArrayInterface $dto DTO obsahující parametry klíče
     * @return string sestavený klíč
     */
    public static function buildKey(KeyEnumInterface $key, ToArrayInterface $dto): string
    {
        $parameters = $dto->toArray();

        if ($parameters === []) {
            return $key->getValue();
        }

        $paramsAsString = array_map('strval', $parameters);

        return sprintf('%s_%s', $key->getValue(), implode('_', $paramsAsString));
    }
}
