<?php

declare(strict_types=1);

namespace App\Service;

/**
 * Service pro práci s počtem zobrazení produktů.
 *
 * Používá filesystem pro ukládání počtu zobrazení
 * jednotlivých produktů.
 */
class CounterService
{
    private string $dir;

    public function __construct(string $countersDir)
    {
        $this->dir = $countersDir . '/var/counters';

        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0777, true);
        }
    }

    /**
     * Zvýší počet zobrazení produktu o 1.
     *
     * @param int $id id produktu
     * @return int počet zobrazení produktu
     */
    public function increment(int $id): int
    {
        $file = $this->getFile($id);

        $fp = fopen($file, 'c+');

        if (!$fp) {
            throw new \RuntimeException("Could not open file: " . $file);
        }

        try {
            if (!flock($fp, LOCK_EX)) {
                throw new \RuntimeException("Could not acquire lock");
            }

            rewind($fp);
            $content = stream_get_contents($fp);
            $current = $content !== '' ? (int)$content : 0;

            $newValue = $current + 1;

            rewind($fp);
            ftruncate($fp, 0);
            fwrite($fp, (string)$newValue);
            fflush($fp);

            return $newValue;
        } finally {
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    }

     /**
     * Vrátí počet zobrazení produktu.
     *
     *
     * @param int $id id produktu
     * @return int počet zobrazení produktu
     */
    public function getCount(int $id): int
    {
        $file = $this->getFile($id);

        if (!file_exists($file)) {
            return 0;
        }

        $fp = fopen($file, 'r');

        if (!$fp) {
            throw new \RuntimeException("Could not open file: " . $file);
        }

        try {
            if (!flock($fp, LOCK_SH)) {
                throw new \RuntimeException("Could not acquire lock");
            }

            $content = stream_get_contents($fp);
            return $content !== '' ? (int)$content : 0;
        } finally {
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    }

    /**
     * Pomocná metoda, vrátí celou cestu k souboru počítadla product_{id}_counter
     *
     *
     * @param int $id id produktu
     * @return string cesta k souboru počítadla daného produktu
     */
    private function getFile(int $id): string
    {
        return $this->dir . "/product_{$id}_counter";
    }
}
