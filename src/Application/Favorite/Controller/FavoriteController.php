<?php

namespace App\Application\Favorite\Controller;


use App\Application\Common\Controller\BaseController;
use App\Application\Common\Repository\FavoriteRepository;
use App\Application\Common\Repository\SerieRepository;
use App\Application\Episodes\Helpers\EpisodeHelper;
use App\Application\Series\Controller\SeriesController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class FavoriteController
 * @package App\Application\Favorite\Controller
 */
class FavoriteController extends BaseController
{
    /**
     * @var SerieRepository
     */
    private $serieRepository;
    /**
     * @var FavoriteRepository
     */
    private $favoriteRepository;
    /**
     * @var SeriesController
     */
    private $seriesController;
    /**
     * @var EpisodeHelper
     */
    private $episodeHelper;

    public function __construct(
        SerieRepository $serieRepository,
        FavoriteRepository $favoriteRepository,
        SeriesController $seriesController,
        EpisodeHelper $episodeHelper
    ) {
        $this->serieRepository = $serieRepository;
        $this->favoriteRepository = $favoriteRepository;
        $this->seriesController = $seriesController;
        $this->episodeHelper = $episodeHelper;
    }

    /**
     * @Route("/toggle.favorite/{lastRoute}/{id}/{search}", name="toggle.favorite")
     * @param string $lastRoute
     * @param string $id
     * @param string|null $search
     * @return RedirectResponse
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function toggleFavorite(string $lastRoute, string $id, string $search = null): RedirectResponse
    {
        $serie = $this->findByRepository($this->serieRepository,$id);
        $user = $this->getUser();
        $favorite = $this->favoriteRepository->getFavorite($user, $id);
        if ($favorite == null) {
            if(empty($serie)) {
                $serie = $this->seriesController->add($id);
            }
            $favorite = $this->favoriteRepository->new($user, $serie);
            $this->favoriteRepository->save($favorite);

        } else {
            $favorite->removeFromAssociations($user, $serie);
            $this->favoriteRepository->delete($favorite->getId());

            if(count($serie->getFavorites()) == 0) {
                $this->seriesController->delete($id);
            }
        }
        return $this->redirectToRoute($lastRoute,[
            'id' => $id,
            'search' => $search
        ]);
    }

    /**
     * @Route("/episode/{episodeNumber}/seen/{serieId}/{seasonNumber}", name="set.episode.seen.status")
     */
    public function setEpisodeSeenStatus(string $episodeNumber, string $serieId, string $seasonNumber, Request $request): Response
    {
        $user = $this->getUser();

        if(empty($user)) {
            $message = 'Veuillez vous connecter';
            $this->addFlash('danger',$message);

            return $this->json(['message', $message], 403);
        }

        $favorite = $this->favoriteRepository->getFavorite($user, $serieId);
        if(!$favorite) {
            $message = 'Veuillez ajouter la série dans les favoris';
            $this->addFlash('danger',$message);

            return $this->json(['message', $message], 403);
        }

        $episodeCode = $this->episodeHelper->buildEpisodeCode($seasonNumber, $episodeNumber);
        if ($favorite->isEpisodeSeen($episodeCode)) {
            $favorite->removeEpisodesSeen($episodeCode);

            $message = 'Episode ' . $episodeCode . ' retiré de la liste';

            $this->favoriteRepository->save($favorite);

            return $this->json([
                'message' => $message,
                'seen' => ' A voir',
                'oldClass' => 'fa-check',
                'newClass' => 'fa-times'
            ], 200);
        } else {

            $favorite->addEpisodesSeen($episodeCode);

            $message = 'Episode ' . $episodeCode . ' vu';

            $this->favoriteRepository->save($favorite);

            return $this->json([
                'message' => $message,
                'seen' => ' Vu',
                'oldClass' => 'fa-times',
                'newClass' => 'fa-check'
            ], 200);
        }
    }
}