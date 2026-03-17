<?php

declare(strict_types=1);

namespace App\Repository;

/**
 * Rozhraní pro repozitáře.
 *
 * Definuje základní operace, které musí každá repository implementovat.
 */
interface RepositoryInterface
{
    /**
     * Najde záznam podle jeho id.
     *
     * @param int $id Identifikátor záznamu
     * @return array<string,mixed> Asociativní pole obsahující data záznamu
     */
    public function findById(int $id): array;
}
