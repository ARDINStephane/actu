<?php

namespace App\Application\Doctrine\Repository;

use App\Application\Common\Entity\Favorite;
use App\Application\Common\Repository\FavoriteRepository;
use App\Application\Doctrine\Entity\DoctrineFavorite;

/**
 * Class DoctrineFavoriteRepository
 * @package App\Application\Doctrine\Repository
 */
class DoctrineFavoriteRepository extends DoctrineBaseRepository implements FavoriteRepository
{
    protected $class = DoctrineFavorite::class;

    /**
     * @param $user
     * @param $serieId
     * @return Favorite|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getFavorite($user, $serieId): ?Favorite
    {
        if(empty($user) || empty($serieId)) {
            return null;
        }
        return $this->createQueryBuilder()
            ->select('o')
            ->where('o.user = :user')
            ->andWhere('o.serie = :serie')
            ->setParameter('serie', $serieId)
            ->setParameter('user', $user->getId())
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function testQuery()
    {
        return $this->createQueryBuilder()
            ->join('o.serie', 's')
            ->addSelect('s')
            ->join('o.user', 'u')
            ->addSelect('u')
            ->where('o.user = :user')
            ->andWhere('o.serie = :serie')
            ->setParameter('serie', $serieId)
            ->setParameter('user', $user->getId())
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}