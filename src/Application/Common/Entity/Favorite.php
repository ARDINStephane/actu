<?php

namespace App\Application\Common\Entity;


interface Favorite
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;

    /**
     * @param mixed $createdAt
     * @return \App\Application\Common\Entity\Favorite
     */
    public function setCreatedAt($createdAt): Favorite;

    /**
     * @return Serie
     */
    public function getSerie(): Serie;

    /**
     * @param Serie $serie
     * @return \App\Application\Common\Entity\Favorite
     */
    public function setSerie(Serie $serie): Favorite;

    /**
     * @return User
     */
    public function getUser(): User;

    /**
     * @param User $user
     * @return \App\Application\Common\Entity\Favorite
     */
    public function setUser(User $user): Favorite;

    /**
     * @param User $user
     * @param Serie $serie
     * @return Favorite
     */
    public function removeFromAssociations(User $user, Serie $serie): Favorite;

    /**
     * @param $episodeCode
     * @return bool
     */
    public function isEpisodeSeen(string $episodeCode): bool;

    /**
     * @param bool $episodeSeen
     * @return Favorite
     */
    public function setEpisodeSeen(bool $episodeSeen): Favorite;

    /**
     * @return array|null
     */
    public function getEpisodesSeen(): ?array;

    /**
     * @param string $episodeCode
     * @return Favorite
     */
    public function addEpisodesSeen(string $episodeCode): Favorite;

    /**
     * @param string $episodeCode
     * @return bool
     */
    public function removeEpisodesSeen(string $episodeCode): bool;

    /**
     * @return string
     */
    public function getEpisodeCode(): string;

    /**
     * @param string $episodeCode
     * @return Favorite
     */
    public function setEpisodeCode(string $episodeCode): Favorite;
}