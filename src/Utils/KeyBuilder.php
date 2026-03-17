<?php

declare(strict_types=1);

namespace App\Utils;

class KeyBuilder
{
    /**
     * @param KeyEnumInterface $key
     * @param ToArrayInterface $dto
     * @return string
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
