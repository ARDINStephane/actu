<?php

namespace App\Application\Doctrine\Repository;

use App\Application\Common\Repository\SerieRepository;
use App\Application\Doctrine\Entity\DoctrineEpisode;

/**
 * Class DoctrineSerieRepository
 * @package App\Application\Doctrine\Repository
 */
class DoctrineEpisodeRepository extends DoctrineBaseRepository implements SerieRepository
{
    protected $class = DoctrineEpisode::class;
}