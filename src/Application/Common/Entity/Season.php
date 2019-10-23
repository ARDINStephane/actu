<?php

namespace App\Application\Common\Entity;


use Doctrine\Common\Collections\Collection;

interface Season
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param mixed $id
     * @return Season
     */
    public function setId($id);

    /**
     * @return string|null
     */
    public function getNumber(): ?string;

    /**
     * @param string|null $number
     * @return Season
     */
    public function setNumber(?string $number): Season;

    /**
     * @return array|null
     */
    public function getImages(): ?array;

    /**
     * @param array|null $images
     * @return Season
     */
    public function setImages(?array $images): Season;

    /**
     * @return string|null
     */
    public function getYear(): ?string;

    /**
     * @param string|null $year
     * @return Season
     */
    public function setYear(?string $year): Season;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @param string|null $description
     * @return Season
     */
    public function setDescription(?string $description): Season;

    /**
     * @return array|null
     */
    public function getNote(): ?array;

    /**
     * @param array|null $note
     * @return Season
     */
    public function setNote(?array $note): Season;

    /**
     * @return string|null
     */
    public function getSeasonShow(): ?string;

    /**
     * @param string|null $seasonShow
     * @return Season
     */
    public function setSeasonShow(?string $seasonShow): Season;

    /**
     * @return bool
     */
    public function getSeen(): bool;

    /**
     * @param bool $seen
     * @return Season
     */
    public function setSeen(bool $seen): Season;

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;

    /**
     * @param \DateTime $updatedAt
     * @return Season
     */
    public function setUpdatedAt($updatedAt): Season;

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;

    /**
     * @param mixed $createdAt
     * @return Season
     */
    public function setCreatedAt($createdAt): Season;

    /**
     * @return mixed
     */
    public function getSerie();

    /**
     * @param mixed $serie
     * @return Season
     */
    public function setSerie($serie): Season;

    /**
     * @return Collection|Episode[];
     */
    public function getEpisodes(): Collection;

    /**
     * @param Episode $episode
     * @return Season
     */
    public function addEpisodes(Episode $episode): Season;

    /**
     * @param Episode $episode
     * @return Season
     */
    public function removeEpisodes(Episode $episode): Season;

    /**
     * @return Episode
     */
    public function getLastEpisodeSeen(): Episode;

    /**
     * @param Episode $lastEpisodeSeen
     * @return Season
     */
    public function setLastEpisodeSeen(Episode $lastEpisodeSeen);
}