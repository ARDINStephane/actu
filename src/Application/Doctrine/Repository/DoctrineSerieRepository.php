<?php

namespace App\Application\Doctrine\Repository;

use App\Application\Common\Repository\SerieRepository;
use App\Application\Doctrine\Entity\DoctrineSerie;

/**
 * Class DoctrineSerieRepository
 * @package App\Application\Doctrine\Repository
 */
class DoctrineSerieRepository extends DoctrineBaseRepository implements SerieRepository
{
    protected $class = DoctrineSerie::class;

    public function listByRecentUpdate(): array
    {
        return $this->createQueryBuilder()
            ->orderBy('o.updatedAt', 'DESC')
            ->addOrderBy('o.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function delete(int $id): void
    {
        $this->createQueryBuilder()
            ->delete($this->class,'o')
            ->where('o.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
    }
}