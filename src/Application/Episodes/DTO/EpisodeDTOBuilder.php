<?php

namespace App\Application\Episodes\DTO;


use App\Api\BetaseriesApi\Provider\EpisodeByApiProvider;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EpisodeDTOBuilder
{
    const Index = 'index';
    const Search = 'search';
    const DoctrineEpisode = 'DoctrineEpisode';

    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var EpisodeByApiProvider
     */
    private $episodesProvider;

    public function __construct(
        RouterInterface $router,
        TokenStorageInterface $tokenStorage,
        EpisodeByApiProvider $episodesProvider
    ) {
        $this->router = $router;
        $this->tokenStorage = $tokenStorage;
        $this->episodesProvider = $episodesProvider;
    }

    /**
     * @param array $episode
     * @param array $serie
     * @return EpisodeCardDTO
     */
    public function build(array $episode, array $serie): EpisodeCardDTO
    {
        $id = $episode['id'];
        $description= $episode['description'];
        $note = $episode['note'];
        $code = $episode['code'];
        $seen = false;
        $seasonNumber = $episode['season'];
        $episodeNumber = $episode['episode'];

        return new EpisodeCardDTO(
            $id,
            $serie,
            $description,
            $note,
            $code,
            $seen,
            $seasonNumber,
            $episodeNumber
        );
    }
}