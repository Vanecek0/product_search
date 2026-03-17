<?php

namespace App\Driver;

interface ElasticSearchDriverInterface
{
    public function findById(string $id): array;
}