<?php

namespace App\Application\Series\DTO;


class SerieCardDTO
{
    /**
     * @var string|null
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
    private $numberOfepisodes;
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
     * @var string|null
     */
    private $toggleFavorite;
    /**
     * @var bool
     */
    private $isfavorite;

    public function __construct(
        ?string $id,
        ?string $title,
        string $slug,
        ?array $alias,
        ?array $images,
        ?string $year,
        ?string $origin,
        ?array $genre,
        ?string $numberOfSeasons,
        ?array $seasonsDetails,
        ?string $numberOfepisodes,
        ?string $lastEpisode,
        ?string $description,
        ?array $note,
        ?string $status,
        ?string $serieShow,
        bool $isfavorite,
        ?string $toggleFavorite
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->slug = $slug;
        $this->alias = $alias;
        $this->images = $images;
        $this->year = $year;
        $this->origin = $origin;
        $this->genre = $genre;
        $this->numberOfSeasons = $numberOfSeasons;
        $this->seasonsDetails = $seasonsDetails;
        $this->numberOfepisodes = $numberOfepisodes;
        $this->lastEpisode = $lastEpisode;
        $this->description = $description;
        $this->note = $note;
        $this->status = $status;
        $this->serieShow = $serieShow;
        $this->toggleFavorite = $toggleFavorite;
        $this->isfavorite = $isfavorite;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'alias' => $this->alias,
            'images' => $this->images,
            'year' => $this->year,
            'origin' => $this->origin,
            'genre' => $this->genre,
            'numberOfSeasons' => $this->numberOfSeasons,
            'numberOfnumberOfepisodes' => $this->numberOfepisodes,
            'lastEpisode' => $this->lastEpisode,
            'description' => $this->description,
            'note' => $this->note,
            'status' => $this->status,
            'serieShow' => $this->serieShow,
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
     * @return SerieCardDTO
     */
    public function setId(?string $id): SerieCardDTO
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
     * @return SerieCardDTO
     */
    public function setTitle(?string $title): SerieCardDTO
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getAlias(): ?array
    {
        return $this->alias;
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
     * @return SerieCardDTO
     */
    public function setSlug(string $slug): SerieCardDTO
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @param array|null $alias
     * @return SerieCardDTO
     */
    public function setAlias(?array $alias): SerieCardDTO
    {
        $this->alias = $alias;
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
     * @return SerieCardDTO
     */
    public function setImages(?array $images): SerieCardDTO
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
     * @return SerieCardDTO
     */
    public function setYear(?string $year): SerieCardDTO
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
     * @return SerieCardDTO
     */
    public function setOrigin(?string $origin): SerieCardDTO
    {
        $this->origin = $origin;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getGenre(): ?array
    {
        return $this->genre;
    }

    /**
     * @param array|null $genre
     * @return SerieCardDTO
     */
    public function setGenre(?array $genre): SerieCardDTO
    {
        $this->genre = $genre;
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
     * @return SerieCardDTO
     */
    public function setNumberOfSeasons(?string $numberOfSeasons): SerieCardDTO
    {
        $this->numberOfSeasons = $numberOfSeasons;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getSeasonsDetails(): ?array
    {
        return $this->seasonsDetails;
    }

    /**
     * @param array|null $seasonsDetails
     * @return SerieCardDTO
     */
    public function setSeasonsDetails(?array $seasonsDetails): SerieCardDTO
    {
        $this->seasonsDetails = $seasonsDetails;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumberOfEpisodes(): ?string
    {
        return $this->numberOfepisodes;
    }

    /**
     * @param string|null $numberOfepisodes
     * @return SerieCardDTO
     */
    public function setNumberOfEpisodes(?string $numberOfepisodes): SerieCardDTO
    {
        $this->numberOfepisodes = $numberOfepisodes;
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
     * @return SerieCardDTO
     */
    public function setLastEpisode(?string $lastEpisode): SerieCardDTO
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
     * @return SerieCardDTO
     */
    public function setDescription(?string $description): SerieCardDTO
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
     * @return SerieCardDTO
     */
    public function setNote(?array $note): SerieCardDTO
    {
        $this->note = $note;
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
     * @return SerieCardDTO
     */
    public function setStatus(?string $status): SerieCardDTO
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
     * @return SerieCardDTO
     */
    public function setSerieShow(?string $serieShow): SerieCardDTO
    {
        $this->serieShow = $serieShow;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getToggleFavorite(): ?string
    {
        return $this->toggleFavorite;
    }

    /**
     * @param string|null $toggleFavorite
     * @return SerieCardDTO
     */
    public function setToggleFavorite(?string $toggleFavorite): SerieCardDTO
    {
        $this->toggleFavorite = $toggleFavorite;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIsfavorite(): bool
    {
        return $this->isfavorite;
    }

    /**
     * @param bool $isfavorite
     * @return SerieCardDTO
     */
    public function setIsfavorite(bool $isfavorite): SerieCardDTO
    {
        $this->isfavorite = $isfavorite;
        return $this;
    }
}