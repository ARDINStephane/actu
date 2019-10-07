<?php

namespace App\Application\Series\DTO;


use Cocur\Slugify\Slugify;
use Symfony\Component\Routing\RouterInterface;

class SerieDTOByApiBuilder
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(
        RouterInterface $router
    ) {
        $this->router = $router;
    }

    /**
     * @param $serie
     * @return SerieCardDTO
     */
    public function build($serie): SerieCardDTO
    {
        $id = $serie['id'];
        $title= $serie['original_title'];
        $slug = $this->slugify($title);
        $alias= $serie['aliases'];
        $images= $serie['images'];
        $year= $serie['creation'];
        $origin= $serie['language'];
        $genre= $serie['genres'];
        $numberOfSeasons= $serie['seasons'];
        $seasonsDetails= $serie['seasons_details'];
        $episodes= $serie['episodes'];
        $lastEpisode= $this->getLastEpisode($seasonsDetails);
        $description= $serie['description'];
        $note= $serie['notes'];
        $status= $serie['status'];
        $serieShow = $this->router->generate('serie.show', ['id' => $id]);
        //$toggleFavorite = $this->router->generate('toggle_favorite', ['id' => $seire]);

        return new SerieCardDTO(
            $id,
            $title,
            $slug,
            $alias,
            $images,
            $year,
            $origin,
            $genre,
            $numberOfSeasons,
            $seasonsDetails,
            $episodes,
            $lastEpisode,
            $description,
            $note,
            $status,
            $serieShow
        );
    }

    /**
     * @param $seasonsDetails
     * @return string
     */
    protected function getLastEpisode($seasonsDetails): string
    {
        $lastSeason = end($seasonsDetails);
        if (strlen($lastSeason['episodes'] < 10)) {
            $lastSeason['episodes'] = '0' . $lastSeason['episodes'];
        }
        if (strlen($lastSeason['number'] < 10)) {
            $lastSeason['number'] = '0' . $lastSeason['number'];
        }

        return $lastEpisode = 'S' . $lastSeason['number'] . ' E' . $lastSeason['episodes'];
    }

    /**
     * @param string $title
     * @return string
     */
    protected function slugify(string $title): string
    {
        $slugify = new Slugify();

        return $slugify->slugify($title);
    }
}