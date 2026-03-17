<?php

namespace App\Utils;

use ToArrayInterface;

class KeyBuilder
{
    public static function buildKey(KeyEnumInterface $key, ToArrayInterface $dto): string
    {
        $parameters = $dto->toArray();

        return count($parameters) === 0 ? $key->value : sprintf('%s_%s', $key->value, implode('_', $parameters));
    }
}
