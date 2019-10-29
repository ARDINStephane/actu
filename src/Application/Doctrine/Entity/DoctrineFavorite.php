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
    /**
     * @var bool
     */
    private $episodeSeen = false;
    /**
     * @var array|null
     */
    private $episodesSeen;
    /**
     * @var string
     */
    private $episodeCode;

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

    /**
     * @param $episodeCode
     * @return bool
     */
    public function isEpisodeSeen(string $episodeCode): bool
    {
        if(in_array($episodeCode, $this->getEpisodesSeen())) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param bool $episodeSeen
     * @return Favorite
     */
    public function setEpisodeSeen(bool $episodeSeen): Favorite
    {
        $this->episodeSeen = $episodeSeen;
        return $this;
    }

    /**
     * @return array
     */
    public function getEpisodesSeen(): array
    {
        if (!empty($this->episodesSeen)) {
            return (json_decode($this->episodesSeen, true));
        } else
            return [];
    }

    /**
     * @param string $episodeCode
     * @return Favorite
     */
    public function addEpisodesSeen(string $episodeCode): Favorite
    {
        $episodesSeen = $this->getEpisodesSeen();
        $episodesSeen[] = $episodeCode;
        $this->episodesSeen = json_encode($episodesSeen);

        return $this;
    }

    /**
     * @param string $episodeCode
     * @return bool
     */
    public function removeEpisodesSeen(string $episodeCode): bool
    {
        $key = array_search($episodeCode, $this->getEpisodesSeen(), true);
        if ($key === false) {
            return false;
        }

        $episodesSeen = json_decode($this->episodesSeen, true);
        unset($episodesSeen[$key]);

        $this->episodesSeen = json_encode($episodesSeen);

        return true;
    }

    /**
     * @return string
     */
    public function getEpisodeCode(): string
    {
        return $this->episodeCode;
    }

    /**
     * @param string $episodeCode
     * @return Favorite
     */
    public function setEpisodeCode(string $episodeCode): Favorite
    {
        $this->episodeCode = $episodeCode;
        return $this;
    }
}
