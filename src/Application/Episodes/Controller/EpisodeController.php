<?php

namespace App\Application\Episodes\Controller;


use App\Api\BetaseriesApi\Provider\EpisodeByApiProvider;
use App\Api\BetaseriesApi\Provider\SerieByApiProvider;
use App\Application\Common\Controller\BaseController;
use App\Application\Search\Controller\SearchController;
use App\Application\Episodes\DTO\EpisodeDTOBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EpisodeController
 * @package App\Application\Episodes
 */
class EpisodeController extends BaseController
{
    /**
     * @var SearchController
     */
    private $searchController;
    /**
     * @var EpisodeByApiProvider
     */
    private $episodeByApiProvider;
    /**
     * @var EpisodeDTOBuilder
     */
    private $episodeDTOBuilder;
    /**
     * @var SerieByApiProvider
     */
    private $serieByApiProvider;

    public function __construct(
        SearchController $searchController,
        EpisodeByApiProvider $episodeByApiProvider,
        EpisodeDTOBuilder $episodeDTOBuilder,
        SerieByApiProvider $serieByApiProvider
    )
    {
        $this->searchController = $searchController;
        $this->episodeByApiProvider = $episodeByApiProvider;
        $this->episodeDTOBuilder = $episodeDTOBuilder;
        $this->serieByApiProvider = $serieByApiProvider;
    }

    /**
     * @Route("/episode/{episodeNumber}/show/{serieId}/{seasonNumber}", name="episode.show")
     * @param string $episodeNumber
     * @param string $serieId
     * @param Request $request
     * @param string $seasonNumber
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function show(string $episodeNumber, string $serieId,  Request $request, string $seasonNumber): Response
    {
        $form = $this->searchController->handleForm($request);

        $serie = $this->serieByApiProvider->provideSerieByApi($serieId);

        $episode = $this->episodeByApiProvider->provideEpisodeByApi($episodeNumber, $serieId, $seasonNumber);
        $episode = $this->episodeDTOBuilder->build($episode, $serie);

        return $this->render('pages/show_episode.html.twig', [
            'episode' => $episode,
            'form' => $form->createView()
        ]);
    }
}