<?php

namespace App\Application\Common\Entity;


use Doctrine\Common\Collections\Collection;

interface Serie
{
    /**
     * @return string|null
     */
    public function getId(): ?string;

    /**
     * @param string|null $id
     * @return Serie
     */
    public function setId(?string $id): Serie;

    /**
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * @param string|null $title
     * @return Serie
     */
    public function setTitle(?string $title): Serie;

    /**
     * @return array|null
     */
    public function getAlias(): ?array;

    /**
     * @return string
     */
    public function getSlug(): string;

    /**
     * @param string $slug
     * @return Serie
     */
    public function setSlug(string $slug): Serie;

    /**
     * @param array|null $alias
     * @return Serie
     */
    public function setAlias(?array $alias): Serie;

    /**
     * @return array|null
     */
    public function getImages(): ?array;

    /**
     * @param array|null $images
     * @return Serie
     */
    public function setImages(?array $images): Serie;

    /**
     * @return string|null
     */
    public function getYear(): ?string;

    /**
     * @param string|null $year
     * @return Serie
     */
    public function setYear(?string $year): Serie;

    /**
     * @return string|null
     */
    public function getOrigin(): ?string;

    /**
     * @param string|null $origin
     * @return Serie
     */
    public function setOrigin(?string $origin): Serie;

    /**
     * @return array|null
     */
    public function getGenre(): ?array;

    /**
     * @param array|null $genre
     * @return Serie
     */
    public function setGenre(?array $genre): Serie;

    /**
     * @return string|null
     */
    public function getNumberOfSeasons(): ?string;

    /**
     * @param string|null $numberOfSeasons
     * @return Serie
     */
    public function setNumberOfSeasons(?string $numberOfSeasons): Serie;

    /**
     * @return array|null
     */
    public function getSeasonsDetails(): ?array;

    /**
     * @param array|null $seasonsDetails
     * @return Serie
     */
    public function setSeasonsDetails(?array $seasonsDetails): Serie;

    /**
     * @return string|null
     */
    public function getNumberOfEpisodes(): ?string;

    /**
     * @param string|null $numberOfEpisodes
     * @return Serie
     */
    public function setNumberOfEpisodes(?string $numberOfEpisodes): Serie;

    /**
     * @return string|null
     */
    public function getLastEpisode(): ?string;

    /**
     * @param string|null $lastEpisode
     * @return Serie
     */
    public function setLastEpisode(?string $lastEpisode): Serie;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @param string|null $description
     * @return Serie
     */
    public function setDescription(?string $description): Serie;

    /**
     * @return array|null
     */
    public function getNote(): ?array;

    /**
     * @param array|null $note
     * @return Serie
     */
    public function setNote(?array $note): Serie;

    /**
     * @return string|null
     */
    public function getStatus(): ?string;

    /**
     * @param string|null $status
     * @return Serie
     */
    public function setStatus(?string $status): Serie;

    /**
     * @return string|null
     */
    public function getSerieShow(): ?string;

    /**
     * @param string|null $serieShow
     * @return Serie
     */
    public function setSerieShow(?string $serieShow): Serie;

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;


    /**
     * @param mixed $updatedAt
     * @return Serie
     */
    public function setUpdatedAt($updatedAt): Serie;


    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;


    /**
     * @param mixed $createdAt
     * @return Serie
     */
    public function setCreatedAt($createdAt);


    /**
     * @return @var bool
     */
    public function getSeen(): bool;


    /**
     * @param bool $seen
     * @return Serie
     */
    public function setSeen($seen): Serie;


    /**
     * @return Collection|Season[]
     */
    public function getSeasons(): Collection;


    /**
     * @param Season $season
     * @return Serie
     */
    public function addSeasons(Season $season): Serie;


    /**
     * @param Season $season
     * @return Serie
     */
    public function removeSeasons(Season $season): Serie;

    /**
     * @return Collection|Episode[]
     */
    public function getEpisodes(): Collection;

    /**
     * @param Episode $episode
     * @return Serie
     */
    public function addEpisodes(Episode $episode): Serie;

    /**
     * @param Episode $episode
     * @return Serie
     */
    public function removeEpisodes(Episode $episode): Serie;

    /**
     * @return string
     */
    public function __toString(): string;
    /**
     * @return Collection|Favorite[]
     */
    public function getFavorites(): Collection;

    /**
     * @param Favorite $favorite
     * @return Serie
     */
    public function addFavorite(Favorite $favorite): Serie;

    /**
     * @param Favorite $favorite
     * @return Serie
     */
    public function removeFavorite(Favorite $favorite): Serie;
}