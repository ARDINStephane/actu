<?php

namespace App\Application\Doctrine\Repository;

use App\Application\Common\Repository\SeasonRepository;
use App\Application\Doctrine\Entity\DoctrineSeason;

/**
 * Class DoctrineSeasonRepository
 * @package App\Application\Doctrine\Repository
 */
class DoctrineSeasonRepository extends DoctrineBaseRepository implements SeasonRepository
{
    protected $class = DoctrineSeason::class;
}