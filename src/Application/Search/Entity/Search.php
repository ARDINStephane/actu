<?php

namespace App\Application\Search\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Search
 * @package App\Application\Search\Entity
 */
class Search
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Search
     */
    public function setName(?string $name): Search
    {
        $this->name = $name;
        return $this;
    }
}