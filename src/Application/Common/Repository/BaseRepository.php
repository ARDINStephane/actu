<?php

namespace App\Application\Common\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * Interface BaseRepository
 * @package App\Application\Common\Repository
 */
interface BaseRepository
{
    /**
     * @param array $List
     */
    public function saveBatch(array $List): void;

    /**
     * @param string $alias
     * @param null $indexBy
     * @return QueryBuilder
     */
    public function createQueryBuilder($alias = 'o', $indexBy = null): QueryBuilder;

    /**
     * @param $object
     */
    public function save($object): void;

    /**
     * @return string
     */
    public function getClass(): string;

    /**
     * @param array ...$args
     * @return mixed
     */
    public function new(...$args);
}