<?php

namespace App\Application\Favorite\Controller;


use App\Application\Common\Controller\BaseController;
use App\Application\Common\Repository\FavoriteRepository;
use App\Application\Common\Repository\SerieRepository;
use App\Application\Episodes\Helpers\EpisodeHelper;
use App\Application\Search\Controller\SearchController;
use App\Application\Series\Controller\SeriesController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @var EpisodeHelper
     */
    private $seriesController;
    /**
     * @var EpisodeHelper
     */
    private $episodeHelper;
    /**
     * @var SearchController
     */
    private $searchController;

    public function __construct(
        SerieRepository $serieRepository,
        FavoriteRepository $favoriteRepository,
        SeriesController $seriesController,
        EpisodeHelper $episodeHelper,
        SearchController $searchController
    ) {
        $this->serieRepository = $serieRepository;
        $this->favoriteRepository = $favoriteRepository;
        $this->seriesController = $seriesController;
        $this->episodeHelper = $episodeHelper;
        $this->searchController = $searchController;
    }

    /**
     * @Route("/toggle.favorite/{id}", name="toggle.favorite")
     * @param string $id
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function toggleFavorite(string $id): Response
    {
        $serie = $this->findByRepository($this->serieRepository,$id);
        $user = $this->checkConnectedUser();
        $favorite = $this->favoriteRepository->getFavorite($user, $id);

        if ($favorite == null) {
            if(empty($serie)) {
                $serie = $this->seriesController->add($id);
            }
            $favorite = $this->favoriteRepository->new($user, $serie);
            $this->favoriteRepository->save($favorite);

            $message = 'Ajouté dans les favoris';
            $newClass = 'btn-danger';
            $oldClass = 'btn-primary';
            $label = 'Supprimer des favoris';

        } else {
            $favorite->removeFromAssociations($user, $serie);
            $this->favoriteRepository->delete($favorite->getId());
            if(count($serie->getFavorites()) == 0) {
                $this->seriesController->delete($id);
            }

            $message = 'Retiré des favoris';
            $newClass = 'btn-primary';
            $oldClass = 'btn-danger';
            $label = 'Ajouter en favori';
        }

        return $this->json([
            'message' => $message,
            'label' => $label,
            'newClass' => $newClass,
            'oldClass' => $oldClass
        ], 200);
    }

    /**
     * @Route("/episode/{episodeNumber}/seen/{serieId}/{seasonNumber}", name="set.episode.seen.status")
     */
    public function setEpisodeSeenStatus(string $episodeNumber, string $serieId, string $seasonNumber, Request $request): Response
    {
        $user = $this->checkConnectedUser();
        if ($user instanceof JsonResponse) {
            return $user;
        }
        $favorite = $this->checkFavorite($user, $serieId);
        if ($favorite instanceof JsonResponse) {
            return $favorite;
        }

        $favorite = $this->checkFavorite($user, $serieId);

        $episodeCode = $this->episodeHelper->buildEpisodeCode($seasonNumber, $episodeNumber);
        if ($favorite->isEpisodeSeen($episodeCode)) {
            $favorite->removeEpisodesSeen($episodeCode);

            $message = 'Episode ' . $episodeCode . ' retiré de la liste';

            $this->favoriteRepository->save($favorite);

            return $this->json([
                'message' => $message,
                'seen' => EpisodeHelper::TOSEE,
                'seasonSeen' => EpisodeHelper::SEEALL,
                'oldClass' => 'fa-check',
                'newClass' => 'fa-times'
            ], 200);
        } else {

            $favorite->addEpisodesSeen($episodeCode);

            $message = 'Episode ' . $episodeCode . EpisodeHelper::SEEN;

            $this->favoriteRepository->save($favorite);

            return $this->json([
                'message' => $message,
                'seen' => EpisodeHelper::SEEN,
                'seasonSeen' => EpisodeHelper::SEEALL,
                'oldClass' => 'fa-times',
                'newClass' => 'fa-check'
            ], 200);
        }
    }

    /**
     * @return object|\Symfony\Component\HttpFoundation\JsonResponse|null
     */
    protected function checkConnectedUser()
    {
        $user = $this->getUser();

        if(empty($user)) {
            $message = 'Veuillez vous connecter';
            $this->addFlash('danger',$message);

            return $this->json(['message', $message], 403);
        }

        return $user;
    }

    /**
     * @param $user
     * @param string $serieId
     * @return \App\Application\Common\Entity\Favorite|\Symfony\Component\HttpFoundation\JsonResponse|null
     */
    protected function checkFavorite($user, string $serieId)
    {
        $favorite = $this->favoriteRepository->getFavorite($user, $serieId);

        if(!$favorite) {
            $message = 'Veuillez ajouter la série dans les favoris';
            $this->addFlash('danger',$message);

            return $this->json(['message', $message], 403);
        }

        return $favorite;
    }

    /**
     * @Route("/season/seen/{serieId}/{seasonNumber}", name="set.season.seen.status")
     * @param string $serieId
     * @param string $seasonNumber
     * @return \App\Application\Common\Entity\Favorite|object|JsonResponse|null
     */
    public function setSeasonSeenStatus(string $serieId, string $seasonNumber)
    {
        $user = $this->checkConnectedUser();
        if ($user instanceof JsonResponse) {
            return $user;
        }
        $favorite = $this->checkFavorite($user, $serieId);
        if ($favorite instanceof JsonResponse) {
            return $favorite;
        }

        $episodes = $this->episodeHelper->getSeasonAllEpisodesCode($favorite, $seasonNumber);
        if(count($this->episodeHelper->getNotSeenEpisodesCode($favorite, $episodes)) != 0) {
            $favorite->setAllEpisodesSeen($episodes);
            $response = [
                'message' => 'Serie vue',
                'seasonSeen' => EpisodeHelper::ALLSEEN,
                'oldClass' => 'fa-times',
                'newClass' => 'fa-check',
                'episodeSeen' => EpisodeHelper::SEEN,
                'oldEpisodeClass' => 'fa-times',
                'newEpisodeClass' => 'fa-check'
            ];
        } else {
            $favorite->removeAllEpisodesSeen($episodes);
            $response = [
                'message' => 'Serie à voir',
                'seasonSeen' => EpisodeHelper::SEEALL,
                'oldClass' => 'fa-check',
                'newClass' => 'fa-times',
                'episodeSeen' => EpisodeHelper::TOSEE,
                'oldEpisodeClass' => 'fa-check',
                'newEpisodeClass' => 'fa-times'
            ];
        }
        $this->favoriteRepository->save($favorite);

        return $this->json($response, 200);
    }

    /**
     * @Route("/favorites/notSeen", name="favorite.not.seen")
     */
    public function getAllEpisodeToSee(Request $request)
    {
        $form = $this->searchController->handleForm($request);

        $allFavorites = [];
        $favorites = $this->getUser()->getFavorites();
        foreach ($favorites as $favorite){
            $seasonsDetails = $favorite->getSerie()->getSeasonsDetails();
            foreach ($seasonsDetails as $season) {
                $fullSeason = $this->episodeHelper->getSeasonAllEpisodesCode($favorite, $season['number']);
                $notSeenBySeason = $this->episodeHelper->getNotSeenEpisodesCode($favorite, $fullSeason);
                if (empty($notSeenBySeason)) {
                    continue;
                }
                $notSeenEpisodes[$season['number']] = $this->episodeHelper->getNotSeenEpisodesCode($favorite, $fullSeason);
            }
            $allFavorites[$favorite->getSerie()->getSlug()] = $notSeenEpisodes;
            $notSeenEpisodes = [];
        }

        return $this->render('pages/list_episodes_seen.html.twig', [
            'allFavorites' => $allFavorites,
            'form' => $form->createView(),
            'current_menu' =>SeriesController::USER
        ]);
    }
}