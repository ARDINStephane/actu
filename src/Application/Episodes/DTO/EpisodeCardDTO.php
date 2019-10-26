<?php

namespace App\Application\Episodes\DTO;


/**
 * Class SerieCardDTO
 * @package App\Application\Series\DTO
 */
class EpisodeCardDTO
{
    /**
     * @var string|null
     */
    private $id;
    /**
     * @var array|null
     */
    private $serie;
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
    private $code;
    /**
     * @var bool
     */
    private $seen;

    public function __construct(
        ?string $id,
        ?array $serie,
        ?string $description,
        ?array $note,
        ?string $code,
        bool $seen
    ) {

        $this->id = $id;
        $this->serie = $serie;
        $this->description = $description;
        $this->note = $note;
        $this->code = $code;
        $this->seen = $seen;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'serie' => $this->serie,
            'description' => $this->description,
            'note' => $this->note,
            'code' => $this->code,
            'seen' => $this->seen,
        ];
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
     * @return EpisodeCardDTO
     */
    public function setId(?string $id): EpisodeCardDTO
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getSerie(): ?array
    {
        return $this->serie;
    }

    /**
     * @param array|null $serie
     * @return EpisodeCardDTO
     */
    public function setSerie(?array $serie): EpisodeCardDTO
    {
        $this->serie = $serie;
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
     * @return EpisodeCardDTO
     */
    public function setDescription(?string $description): EpisodeCardDTO
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
     * @return EpisodeCardDTO
     */
    public function setNote(?array $note): EpisodeCardDTO
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return EpisodeCardDTO
     */
    public function setCode(?string $code): EpisodeCardDTO
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSeen(): bool
    {
        return $this->seen;
    }

    /**
     * @param bool $seen
     * @return EpisodeCardDTO
     */
    public function setSeen(bool $seen): EpisodeCardDTO
    {
        $this->seen = $seen;
        return $this;
    }

}