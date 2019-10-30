<?php

namespace App\Application\Episodes\Controller;


use App\Api\BetaseriesApi\Provider\EpisodeByApiProvider;
use App\Api\BetaseriesApi\Provider\SerieByApiProvider;
use App\Application\Common\Controller\BaseController;
use App\Application\Common\Repository\FavoriteRepository;
use App\Application\Search\Controller\SearchController;
use App\Application\Episodes\DTO\EpisodeDTOBuilder;
use App\Application\Series\Controller\SeriesController;
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
    /**
     * @var FavoriteRepository
     */
    private $favoriteRepository;

    public function __construct(
        SearchController $searchController,
        EpisodeByApiProvider $episodeByApiProvider,
        EpisodeDTOBuilder $episodeDTOBuilder,
        SerieByApiProvider $serieByApiProvider,
        FavoriteRepository $favoriteRepository
    )
    {
        $this->searchController = $searchController;
        $this->episodeByApiProvider = $episodeByApiProvider;
        $this->episodeDTOBuilder = $episodeDTOBuilder;
        $this->serieByApiProvider = $serieByApiProvider;
        $this->favoriteRepository = $favoriteRepository;
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
    public function show(string $episodeNumber, string $serieId, string $seasonNumber, Request $request): Response
    {
        $form = $this->searchController->handleForm($request);

        $serie = $this->serieByApiProvider->provideSerieByApi($serieId);

        $episode = $this->episodeByApiProvider->provideEpisodeByApi($episodeNumber, $serieId, $seasonNumber);
        $episode = $this->episodeDTOBuilder->build($episode, $serie);

        $episodeSeen = SeriesController::TOSEE;

        $user = $this->getUser();

        if (!empty($user)) {
            $favorite = $this->favoriteRepository->getFavorite($user, $serieId);
            if (!empty($favorite)) {
                $episodeSeen = $favorite->isEpisodeSeen($episode->getCode())? SeriesController::SEEN : SeriesController::TOSEE;
            }
        }

        return $this->render('pages/show_episode.html.twig', [
            'episode' => $episode,
            'form' => $form->createView(),
            'episodeSeen' => $episodeSeen
        ]);
    }
}