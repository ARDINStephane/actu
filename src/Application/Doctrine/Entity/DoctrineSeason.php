<?php

namespace App\Application\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Application\Common\Entity\Episode;
use App\Application\Common\Entity\Season;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class DoctrineSeason
 * @ORM\Entity(repositoryClass="App\Application\Doctrine\Repository\DoctrineSeasonRepository")
 * @UniqueEntity("slug")
 * @package App\Application\Doctrine\Entity
 */
class DoctrineSeason implements Season
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
    private $seasonShow;
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
     * @ManyToOne(targetEntity="DoctrineSerie", cascade={"all"}, fetch="EAGER")
     */
    private $serie;

    /**
     * @OneToMany(targetEntity="DoctrineEpisode", mappedBy="season", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $episodes;

    /**
     * @OneToOne(targetEntity="DoctrineEpisode", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     * @JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $lastEpisodeSeen;


    public function __construct()
    {
        $this->episodes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Season
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string|null $number
     * @return Season
     */
    public function setNumber(?string $number): Season
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getImages(): ?array
    {
        return json_decode($this->images);
    }

    /**
     * @param array|null $images
     * @return Season
     */
    public function setImages(?array $images): Season
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
     * @return Season
     */
    public function setYear(?string $year): Season
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
     * @return Season
     */
    public function setDescription(?string $description): Season
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getNote(): ?array
    {
        return json_decode($this->note);
    }

    /**
     * @param array|null $note
     * @return Season
     */
    public function setNote(?array $note): Season
    {
        $this->note = json_encode($note);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSeasonShow(): ?string
    {
        return $this->seasonShow;
    }

    /**
     * @param string|null $seasonShow
     * @return Season
     */
    public function setSeasonShow(?string $seasonShow): Season
    {
        $this->seasonShow = $seasonShow;
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
     * @param \bool $seen
     * @return Season
     */
    public function setSeen(bool $seen): Season
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
     * @param \DateTime $updatedAt
     * @return Season
     */
    public function setUpdatedAt($updatedAt): Season
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
     * @return Season
     */
    public function setCreatedAt($createdAt): Season
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param mixed $serie
     * @return Season
     */
    public function setSerie($serie):Season
    {
        $this->serie = $serie;
        return $this;
    }

    /**
     * @return Collection|Episode[];
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }


    /**
     * @param Episode $episode
     * @return Season
     */
    public function addEpisodes(Episode $episode): Season
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes[] = $episode;
        }

        return $this;
    }

    /**
     * @param Episode $episode
     * @return Season
     */
    public function removeEpisodes(Episode $episode): Season
    {
        if ($this->episodes->contains($episode)) {
            $this->episodes->removeElement($episode);
        }

        return $this;
    }

    /**
     * @return Episode
     */
    public function getLastEpisodeSeen(): Episode
    {
        return $this->lastEpisodeSeen;
    }

    /**
     * @param Episode $lastEpisodeSeen
     * @return DoctrineSeason
     */
    public function setLastEpisodeSeen(Episode $lastEpisodeSeen)
    {
        $this->lastEpisodeSeen = $lastEpisodeSeen;
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