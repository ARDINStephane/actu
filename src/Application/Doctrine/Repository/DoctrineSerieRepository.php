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
}