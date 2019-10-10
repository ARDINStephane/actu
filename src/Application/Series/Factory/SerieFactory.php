<?php

namespace App\Application\Series\Factory;


use App\Application\Common\Entity\Serie;
use App\Application\Common\Repository\SerieRepository;
use Cocur\Slugify\Slugify;
use Symfony\Component\Routing\RouterInterface;

class SerieFactory
{
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var SerieRepository
     */
    private $repository;

    public function __construct(
        RouterInterface $router,
        SerieRepository $repository
    ) {
        $this->router = $router;
        $this->repository = $repository;
    }

    /**
     * @param $serieInfo
     * @return Serie
     */
    public function buildByApi(array $serieInfo): Serie
    {
        $serie = $this->repository->new();

        $id = $serieInfo['id'];
        $serie->setId($id);
        $title = $serieInfo['original_title'];
        $serie->setTitle($title);
        $slug = $this->slugify($title);
        $serie->setSlug($slug);
        $serie->setAlias($serieInfo['aliases']);
        $serie->setImages($serieInfo['images']);
        $serie->setYear($serieInfo['creation']);
        $serie->setOrigin($serieInfo['language']);
        $serie->setGenre($serieInfo['genres']);
        $serie->setNumberOfSeasons($serieInfo['seasons']);
        $serie->setNumberOfEpisodes($serieInfo['episodes']);
        $seasonsDetails = $serieInfo['seasons_details'];
        $serie->setSeasonsDetails($seasonsDetails);
        $lastEpisode= $this->getLastEpisode($seasonsDetails);
        $serie->setNumberOfEpisodes($lastEpisode);
        $serie->setDescription($serieInfo['description']);
        $serie->setNote($serieInfo['notes']);
        $serie->setStatus($serieInfo['status']);
        $serie->setCreatedAt(new \DateTime());
        $serie->setSerieShow($this->router->generate('serie.show', ['id' => $id]));

        //$toggleFavorite = $this->router->generate('toggle_favorite', ['id' => $serie]);

        return $serie;
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