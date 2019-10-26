<?php

namespace App\Application\Favorite\Controller;


use App\Application\Common\Controller\BaseController;
use App\Application\Common\Repository\FavoriteRepository;
use App\Application\Common\Repository\SerieRepository;
use App\Application\Series\Controller\SeriesController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    public function __construct(
        SerieRepository $serieRepository,
        FavoriteRepository $favoriteRepository,
        SeriesController $seriesController
    ) {
        $this->serieRepository = $serieRepository;
        $this->favoriteRepository = $favoriteRepository;
        $this->seriesController = $seriesController;
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
}