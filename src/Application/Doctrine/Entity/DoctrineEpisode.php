<?php

namespace App\Application\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Application\Common\Entity\Episode;
use App\Application\Common\Entity\Season;
use App\Application\Common\Entity\Serie;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class DoctrineEpisode
 * @ORM\Entity(repositoryClass="App\Application\Doctrine\Repository\DoctrineEpisodeRepository")
 * @UniqueEntity("slug")
 * @package App\Application\Doctrine\Entity
 */
class DoctrineEpisode implements Episode
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string")
     */
    private $id;
    /**
     * @var string|null
     */
    private $title;
    /**
     * @var string
     */
    private $slug;
    /**
     * @var string
     */
    private $number;
    /**
     * @var array|null
     */
    private $images;
    /**
     * @var string|null
     */
    private $year;
    /**
     * @var string|null
     */
    private $description;
    /**
     * @var array|null
     */
    private $note;
    /**
     * @var string|null
     */
    private $episodeShow;
    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $seen = false;
    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ManyToOne(targetEntity="DoctrineSeason", cascade={"all"}, fetch="EAGER")
     */
    private $season;

    /**
     * @ManyToOne(targetEntity="DoctrineSerie", cascade={"all"}, fetch="EAGER")
     */
    private $serie;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Episode
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Episode
     */
    public function setTitle(?string $title): Episode
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Episode
     */
    public function setSlug(string $slug): Episode
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return DoctrineEpisode
     */
    public function setNumber(string $number): Episode
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getImages(): ?array
    {
        return json_decode($this->images, true);
    }

    /**
     * @param array|null $images
     * @return Episode
     */
    public function setImages(?array $images): Episode
    {
        $this->images = json_encode($images);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getYear(): ?string
    {
        return $this->year;
    }

    /**
     * @param string|null $year
     * @return Episode
     */
    public function setYear(?string $year): Episode
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Episode
     */
    public function setDescription(?string $description): Episode
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getNote(): ?array
    {
        return json_decode($this->note, true);
    }

    /**
     * @param array|null $note
     * @return Episode
     */
    public function setNote(?array $note): Episode
    {
        $this->note = json_encode($note);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEpisodeShow(): ?string
    {
        return $this->episodeShow;
    }

    /**
     * @param string|null $episodeShow
     * @return Episode
     */
    public function setEpisodeShow(?string $episodeShow): Episode
    {
        $this->episodeShow = $episodeShow;
        return $this;
    }

    /**
     * @return bool
     */
    public function getSeen(): bool
    {
        return $this->seen;
    }

    /**
     * @param bool $seen
     * @return Episode
     */
    public function setSeen(bool $seen): Episode
    {
        $this->seen = $seen;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     * @return Episode
     */
    public function setUpdatedAt($updatedAt): Episode
    {
        $this->updatedAt = $updatedAt;
        return $this;
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
     * @return Episode
     */
    public function setCreatedAt($createdAt): Episode
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Season
     */
    public function getSeason(): Season
    {
        return $this->season;
    }

    /**
     * @param Season $season
     * @return Episode
     */
    public function setSeason(Season $season): Episode
    {
        $this->season = $season;
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
     * @return Episode
     */
    public function setSerie(Serie $serie): Episode
    {
        $this->serie = $serie;
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