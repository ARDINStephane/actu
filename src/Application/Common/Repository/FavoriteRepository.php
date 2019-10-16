<?php

namespace App\Application\Common\Repository;

use App\Application\Common\Entity\Favorite;


/**
 * Interface FavoriteRepository
 * @package App\Application\Common\Repository
 */
interface FavoriteRepository extends BaseRepository
{
    /**
     * @param $user
     * @param $serie
     * @return Favorite|null
     */
    public function getFavorite($user, $serie): ?Favorite;
}