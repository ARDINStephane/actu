<?php

namespace App\Application\Common\Repository;

/**
 * Interface SerieRepository
 * @package App\Application\Common\Repository
 */
interface SerieRepository extends BaseRepository
{
    /**
     * @return array
     */
    public function listByRecentUpdate(): array;

    /**
     * @param int $id
     */
    public function delete(int $id): void;
}