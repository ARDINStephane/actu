<?php

namespace App\Application\Doctrine\Repository;

use App\Application\Common\Repository\UserRepository;
use App\Application\Doctrine\Entity\DoctrineUser;

/**
 * Class DoctrineUserRepository
 * @package App\Application\Doctrine\Repository
 */
class DoctrineUserRepository extends DoctrineBaseRepository implements UserRepository
{
    protected $class = DoctrineUser::class;
}