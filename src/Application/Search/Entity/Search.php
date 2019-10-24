<?php

namespace App\Application\Search\Entity;


/**
 * Class Search
 * @package App\Application\Search\Entity
 */
class Search
{
    /**
     * @var string|null
     */
    private $search;

    /**
     * @return string|null
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }

    /**
     * @param string|null $search
     * @return Search
     */
    public function setSearch(?string $search): Search
    {
        $this->search = $search;
        return $this;
    }
}