<?php

namespace App\Application\Common\Entity;


interface Episode
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $id
     * @return Episode
     */
    public function setId($id);

    /**
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * @param string|null $title
     * @return Episode
     */
    public function setTitle(?string $title): Episode;

    /**
     * @return string
     */
    public function getSlug(): string;

    /**
     * @param string $slug
     * @return Episode
     */
    public function setSlug(string $slug): Episode;

    /**
     * @return array|null
     */
    public function getImages(): ?array;

    /**
     * @param array|null $images
     * @return Episode
     */
    public function setImages(?array $images): Episode;

    /**
     * @return string|null
     */
    public function getYear(): ?string;

    /**
     * @param string|null $year
     * @return Episode
     */
    public function setYear(?string $year): Episode;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @param string|null $description
     * @return Episode
     */
    public function setDescription(?string $description): Episode;

    /**
     * @return array|null
     */
    public function getNote(): ?array;

    /**
     * @param array|null $note
     * @return Episode
     */
    public function setNote(?array $note): Episode;

    /**
     * @return string|null
     */
    public function getEpisodeShow(): ?string;

    /**
     * @param string|null $episodeShow
     * @return Episode
     */
    public function setEpisodeShow(?string $episodeShow): Episode;

    /**
     * @return bool
     */
    public function getSeen(): bool;

    /**
     * @param bool $seen
     * @return Episode
     */
    public function setSeen(bool $seen): Episode;

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;

    /**
     * @param mixed $updatedAt
     * @return Episode
     */
    public function setUpdatedAt($updatedAt): Episode;

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;

    /**
     * @param mixed $createdAt
     * @return Episode
     */
    public function setCreatedAt($createdAt): Episode;

    /**
     * @return Season
     */
    public function getSeason(): Season;

    /**
     * @param Season $season
     * @return Episode
     */
    public function setSeason(Season $season): Episode;

    /**
     * @return Serie
     */
    public function getSerie(): Serie;

    /**
     * @param Serie $serie
     * @return Episode
     */
    public function setSerie(Serie $serie): Episode;
}