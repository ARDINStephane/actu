<?php

namespace App\Application\Doctrine\Repository;

use App\Application\Common\Repository\EpisodeRepository;
use App\Application\Doctrine\Entity\DoctrineEpisode;

/**
 * Class DoctrineEpisodeRepository
 * @package App\Application\Doctrine\Repository
 */
class DoctrineEpisodeRepository extends DoctrineBaseRepository implements EpisodeRepository
{
    protected $class = DoctrineEpisode::class;
}