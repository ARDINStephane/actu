<?php

namespace App\Application\Series\DTO;


use App\Api\BetaseriesApi\Provider\SerieByApiProvider;
use App\Application\Common\Entity\Serie;
use App\Application\Episodes\Helpers\EpisodeHelper;
use Cocur\Slugify\Slugify;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SerieDTOBuilder
{
    const Index = 'index';
    const Search = 'search';
    const DoctrineSerie = 'DoctrineSerie';

    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var SerieByApiProvider
     */
    private $seriesProvider;
    /**
     * @var EpisodeHelper
     */
    private $episodeHelper;

    public function __construct(
        RouterInterface $router,
        TokenStorageInterface $tokenStorage,
        SerieByApiProvider $seriesProvider,
        EpisodeHelper $episodeHelper
    ) {
        $this->router = $router;
        $this->tokenStorage = $tokenStorage;
        $this->seriesProvider = $seriesProvider;
        $this->episodeHelper = $episodeHelper;
    }

    /**
     * @param array $serie
     * @param string $tag
     * @return SerieCardDTO
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function switchAndBuildSerieInfo($serie, string $tag): SerieCardDTO
    {
        switch ($tag) {
            case self::Index:
                $serieDto = $this->build($serie);
                break;
            case self::DoctrineSerie:
                $serieDto = $this->buildDoctrineSerie($serie);
                break;
            case self::Search:
                $betaSerie = $this->seriesProvider->provideSerieByApi($serie['id']);

                $serieDto = $this->build($betaSerie);
                break;
        }

        return $serieDto;
    }

    /**
     * @param array $serie
     * @return SerieCardDTO
     */
    protected function build(array $serie): SerieCardDTO
    {
        //dd($serie['seasons_details'][0]);
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
        $numberOfEpisodes= $serie['episodes'];
        $lastEpisode= $this->getLastEpisode($seasonsDetails);
        $description= $serie['description'];
        $note= $serie['notes'];
        $status= $serie['status'];
        $serieShow = $this->router->generate('serie.show', ['id' => $id]);
        $isfavorite = $this->isUsersFavorite($id);

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
            $numberOfEpisodes,
            $lastEpisode,
            $description,
            $note,
            $status,
            $serieShow,
            $isfavorite
        );
    }

    /**
     * @param Serie $serie
     * @return SerieCardDTO
     */
    protected function buildDoctrineSerie($serie): SerieCardDTO
    {
        $id = $serie->getId();
        $title= $serie->getTitle();
        $slug = $this->slugify($title);
        $alias= $serie->getAlias();
        $images= $serie->getImages();
        $year= $serie->getYear();
        $origin= $serie->getOrigin();
        $genre= $serie->getGenre();
        $numberOfSeasons= $serie->getNumberOfSeasons();
        $seasonsDetails= $serie->getSeasonsDetails();
        $numberOfEpisodes= $serie->getNumberOfEpisodes();
        $lastEpisode= $this->getLastEpisode($seasonsDetails);
        $description= $serie->getDescription();
        $note= $serie->getNote();
        $status= $serie->getStatus();
        $serieShow = $this->router->generate('serie.show', ['id' => $id]);
        $isfavorite = $this->isUsersFavorite($id);

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
            $numberOfEpisodes,
            $lastEpisode,
            $description,
            $note,
            $status,
            $serieShow,
            $isfavorite
        );
    }

    /**
     * @param $seasonsDetails
     * @return string
     */
    protected function getLastEpisode($seasonsDetails): string
    {
        $lastSeason = end($seasonsDetails);

        return $this->episodeHelper->buildEpisodeCode($lastSeason['number'], $lastSeason['episodes']);
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

    /**
     * @return bool
     */
    protected function isUsersFavorite($serieId): bool
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if(empty($user) || $user == "anon.") {
            return false;
        }
        if(!empty($user->getFavorites())) {
            foreach ($user->getFavorites() as $favorite) {
                if($favorite->getSerie()->getId() == $serieId) {
                    return true;
                }
            }
        }
        return false;
    }
}