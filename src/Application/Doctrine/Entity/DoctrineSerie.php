<?php

namespace App\Application\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Application\Common\Entity\Episode;
use App\Application\Common\Entity\Season;
use App\Application\Common\Entity\Serie;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class DoctrineSerie
 * @ORM\Entity(repositoryClass="App\Application\Doctrine\Repository\DoctrineSerieRepository")
 * @UniqueEntity("slug")
 * @package App\Application\Doctrine\Entity
 */
class DoctrineSerie implements Serie
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
    private $alias;
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
    private $origin;
    /**
     * @var array|null
     */
    private $genre;
    /**
     * @var string|null
     */
    private $numberOfSeasons;
    /**
     * @var array|null
     */
    private $seasonsDetails;
    /**
     * @var string|null
     */
    private $numberOfEpisodes;
    /**
     * @var string|null
     */
    private $lastEpisode;
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
    private $status;
    /**
     * @var string|null
     */
    private $serieShow;
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
     * @OneToMany(targetEntity="DoctrineSeason", mappedBy="serie", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $seasons;

    /**
     * @OneToMany(targetEntity="DoctrineEpisode", mappedBy="serie", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $episodes;

    public function __construct()
    {
        $this->seasons = new ArrayCollection();
        $this->episodes = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return Serie
     */
    public function setId(?string $id): Serie
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
     * @return Serie
     */
    public function setTitle(?string $title): Serie
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getAlias(): ?array
    {
        return json_decode($this->alias);
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
     * @return Serie
     */
    public function setSlug(string $slug): Serie
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @param array|null $alias
     * @return Serie
     */
    public function setAlias(?array $alias): Serie
    {
        $this->alias = json_encode($alias);
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
     * @return Serie
     */
    public function setImages(?array $images): Serie
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
     * @return Serie
     */
    public function setYear(?string $year): Serie
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    /**
     * @param string|null $origin
     * @return Serie
     */
    public function setOrigin(?string $origin): Serie
    {
        $this->origin = $origin;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getGenre(): ?array
    {
        return json_decode($this->genre);
    }

    /**
     * @param array|null $genre
     * @return Serie
     */
    public function setGenre(?array $genre): Serie
    {
        $this->genre = json_encode($genre);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumberOfSeasons(): ?string
    {
        return $this->numberOfSeasons;
    }

    /**
     * @param string|null $numberOfSeasons
     * @return Serie
     */
    public function setNumberOfSeasons(?string $numberOfSeasons): Serie
    {
        $this->numberOfSeasons = $numberOfSeasons;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getSeasonsDetails(): ?array
    {
        return json_decode($this->seasonsDetails);
    }

    /**
     * @param array|null $seasonsDetails
     * @return Serie
     */
    public function setSeasonsDetails(?array $seasonsDetails): Serie
    {
        $this->seasonsDetails = json_encode($seasonsDetails);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumberOfEpisodes(): ?string
    {
        return $this->numberOfEpisodes;
    }

    /**
     * @param string|null $numberOfEpisodes
     * @return Serie
     */
    public function setNumberOfEpisodes(?string $numberOfEpisodes): Serie
    {
        $this->numberOfEpisodes = $numberOfEpisodes;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastEpisode(): ?string
    {
        return $this->lastEpisode;
    }

    /**
     * @param string|null $lastEpisode
     * @return Serie
     */
    public function setLastEpisode(?string $lastEpisode): Serie
    {
        $this->lastEpisode = $lastEpisode;
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
     * @return Serie
     */
    public function setDescription(?string $description): Serie
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
     * @return Serie
     */
    public function setNote(?array $note): Serie
    {
        $this->note = json_encode($note);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return Serie
     */
    public function setStatus(?string $status): Serie
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSerieShow(): ?string
    {
        return $this->serieShow;
    }

    /**
     * @param string|null $serieShow
     * @return Serie
     */
    public function setSerieShow(?string $serieShow): Serie
    {
        $this->serieShow = $serieShow;
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
     * @return Serie
     */
    public function setUpdatedAt($updatedAt): Serie
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
     * @return Serie
     */
    public function setCreatedAt($createdAt): serie
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return @var bool
     */
    public function getSeen(): bool
    {
        return $this->seen;
    }

    /**
     * @param mixed $seen
     * @return Serie
     */
    public function setSeen($seen): Serie
    {
        $this->seen = $seen;
        return $this;
    }

    /**
     * @return Collection|Season[]
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    /**
     * @param Season $season
     * @return Serie
     */
    public function addSeasons(Season $season): Serie
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons[] = $season;
        }

        return $this;
    }

    /**
     * @param Season $season
     * @return Serie
     */
    public function removeSeasons(Season $season): Serie
    {
        if ($this->seasons->contains($season)) {
            $this->seasons->removeElement($season);
        }

        return $this;
    }

    /**
     * @return Collection|Episode[]
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    /**
     * @param Episode $episode
     * @return Serie
     */
    public function addEpisodes(Episode $episode): Serie
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes[] = $episode;
        }

        return $this;
    }

    /**
     * @param Episode $episode
     * @return Serie
     */
    public function removeEpisodes(Episode $episode): Serie
    {
        if ($this->episodes->contains($episode)) {
            $this->episodes->removeElement($episode);
        }

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