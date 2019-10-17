<?php

namespace App\Application\Favorite\Controller;


use App\Application\Common\Controller\BaseController;
use App\Application\Common\Repository\FavoriteRepository;
use App\Application\Common\Repository\SerieRepository;
use App\Application\Series\Controller\SeriesController;
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
     * @Route("/toggle_favorite/{id}}", name="toggle_favorite")
     */
    public function toggleFavorite(string $id)
    {
        $serie = $this->findByRepository($this->serieRepository,$id);
        $user = $this->getUser();
        $favorite = $this->favoriteRepository->getFavorite($user, $id);

        if ($favorite == null) {
            if(empty($serie)) {
                $this->seriesController->add($id);
            }
            $favorite = $this->favoriteRepository->new($user, $serie);
            $this->favoriteRepository->save($favorite);
        } else {
            $favorite->removeFromAssociations($user, $serie);
            $this->favoriteRepository->delete($favorite->getId());
            $this->seriesController->delete($id);
        }
        return $this->redirectToRoute('home.index');
    }
}