<?php

namespace App\Application\Doctrine\Entity;

use App\Application\Common\Entity\Favorite;
use App\Application\Common\Entity\Serie;
use App\Application\Common\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="App\Application\Doctrine\Repository\DoctrineFavoriteRepository")
 */
class DoctrineFavorite implements Favorite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    /**
     * @ManyToOne(targetEntity="DoctrineSerie")
     */
    private $serie;
    /**
     * @ManyToOne(targetEntity="DoctrineUser")
     */
    private $user;

    public function __construct(User $user, Serie $serie)
    {
        $this->setSerie($serie);
        $this->setUser($user);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return Favorite
     */
    public function setCreatedAt($createdAt): Favorite
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Serie
     */
    public function getSerie(): Serie
    {
        return $this->serie;
    }

    /**
     * @param Serie $serie
     * @return Favorite
     */
    public function setSerie(Serie $serie): Favorite
    {
        $this->serie = $serie;
        $serie->addFavorite($this);

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Favorite
     */
    public function setUser(User $user): Favorite
    {
        $this->user = $user;
        $user->addFavorite($this);

        return $this;
    }

    /**
     * @param User $user
     * @param Serie $serie
     * @return Favorite
     */
    public function removeFromAssociations(User $user, Serie $serie): Favorite
    {
        $user->removeFavorite($this);
        $serie->removeFavorite($this);

        return $this;

    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
