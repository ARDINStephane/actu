<?php

namespace App\Application\Common\Entity;


use App\Application\Doctrine\Entity\DoctrineUser;
use App\Application\Common\Entity\Favorite;
use Doctrine\Common\Collections\Collection;

interface User
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return string|null
     */
    public function getUsername(): ?string;

    /**
     * @param string $username
     * @return DoctrineUser
     */
    public function setUsername(string $username): User;

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles(): array;

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): User;

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword(): string;

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt(): ?string;

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials(): void;

    /**
     * @param mixed $password
     * @return DoctrineUser
     */
    public function setPassword($password): User;

    /**
     * @return string
     */
    public function serialize(): string;

    /**
     * @param $serialized
     * @return mixed
     */
    public function unserialize($serialized);

    /**
     * @return mixed
     */
    public function getFavorites(): Collection;

    /**
     * @param Collection $favorites
     * @return User
     */
    public function setFavorites(Collection $favorites): User;

    /**
     * @param Favorite $favorite
     * @return User
     */
    public function addFavorite(Favorite $favorite):User;

    /**
     * @param Favorite $favorite
     * @return User
     */
    public function removeFavorite(Favorite $favorite): User;

    /**
     * @return string|null
     */
    public function getEmail(): ?string;

    /**
     * @param string|null $email
     * @return User
     */
    public function setEmail(?string $email): User;
}