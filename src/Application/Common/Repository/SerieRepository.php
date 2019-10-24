<?php

namespace App\Application\Common\Repository;


/**
 * Interface SerieRepository
 * @package App\Application\Common\Repository
 */
interface SerieRepository extends BaseRepository
{
    /**
     * @param $user
     * @return mixed
     */
    public function findFavoritesSeries($user);
}