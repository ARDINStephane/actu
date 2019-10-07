<?php

namespace App\Application\Doctrine\Entity;

use App\Application\Common\Entity\Season;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Serie
 * @ORM\Entity(repositoryClass="App\Application\Doctrine\Repository\EpisodeRepository")
 * @UniqueEntity("slug")
 * @package App\Application\Doctrine\Entity
 */
class DoctrineEpisode
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
     * @ManyToOne(targetEntity="Season", cascade={"all"}, fetch="EAGER")
     */
    private $season;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return DoctrineEpisode
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
     * @return DoctrineEpisode
     */
    public function setTitle(?string $title): DoctrineEpisode
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
     * @return DoctrineEpisode
     */
    public function setSlug(string $slug): DoctrineEpisode
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    /**
     * @param array|null $images
     * @return DoctrineEpisode
     */
    public function setImages(?array $images): DoctrineEpisode
    {
        $this->images = $images;
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
     * @return DoctrineEpisode
     */
    public function setYear(?string $year): DoctrineEpisode
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
     * @return DoctrineEpisode
     */
    public function setDescription(?string $description): DoctrineEpisode
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getNote(): ?array
    {
        return $this->note;
    }

    /**
     * @param array|null $note
     * @return DoctrineEpisode
     */
    public function setNote(?array $note): DoctrineEpisode
    {
        $this->note = $note;
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
     * @return DoctrineEpisode
     */
    public function setEpisodeShow(?string $episodeShow): DoctrineEpisode
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
     * @param mixed $seen
     * @return DoctrineEpisode
     */
    public function setSeen($seen): DoctrineEpisode
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
     * @return DoctrineEpisode
     */
    public function setUpdatedAt($updatedAt): DoctrineEpisode
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
     * @return DoctrineEpisode
     */
    public function setCreatedAt($createdAt): DoctrineEpisode
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeason(): Season
    {
        return $this->season;
    }

    /**
     * @param mixed $season
     * @return DoctrineEpisode
     */
    public function setSeason($season): DoctrineEpisode
    {
        $this->season = $season;
        return $this;
    }

}