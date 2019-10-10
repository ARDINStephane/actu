<?php

namespace App\Application\Doctrine\Repository;

use App\Application\Common\Repository\FavoriteRepository;
use App\Application\Doctrine\Entity\DoctrineFavorite;

/**
 * Class DoctrineFavoriteRepository
 * @package App\Application\Doctrine\Repository
 */
class DoctrineFavoriteRepository extends DoctrineBaseRepository implements FavoriteRepository
{
    protected $class = DoctrineFavorite::class;
}