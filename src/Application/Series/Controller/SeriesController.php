<?php

namespace App\Application\Series\Controller;


use App\Api\BetaseriesApi\Provider\SerieByApiProvider;
use App\Application\Common\Controller\BaseController;
use App\Application\Common\Entity\Serie;
use App\Application\Common\Repository\FavoriteRepository;
use App\Application\Common\Repository\SerieRepository;
use App\Application\Episodes\Helpers\EpisodeHelper;
use App\Application\Helpers\Paginator;
use App\Application\Search\Controller\SearchController;
use App\Application\Series\DTO\SerieDTOBuilder;
use App\Application\Series\Factory\SerieFactory;
use App\Application\Series\Manager\SerieManager;
use App\Application\Series\Provider\SerieProvider;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SeriesController
 * @package App\Application\Series\Controller
 */
class SeriesController extends BaseController
{
    const HOME = "home";
    const USER = "user";

    /**
     * @var SerieByApiProvider
     */
    private $serieByApiProvider;
    /**
     * @var SerieDTOBuilder
     */
    private $serieDTOBuilder;
    /**
     * @var SerieFactory
     */
    private $serieFactory;
    /**
     * @var SerieManager
     */
    private $serieManager;
    /**
     * @var FavoriteRepository
     */
    private $favoriteRepository;
    /**
     * @var SerieRepository
     */
    private $serieRepository;
    /**
     * @var PaginationInterface
     */
    private $paginator;
    /**
     * @var SerieProvider
     */
    private $serieProvider;
    /**
     * @var SearchController
     */
    private $searchController;
    /**
     * @var EpisodeHelper
     */
    private $episodeHelper;

    public function __construct(
        SerieByApiProvider $serieByApiProvider,
        SerieDTOBuilder $serieDTOBuilder,
        SerieFactory $serieFactory,
        SerieManager $serieManager,
        FavoriteRepository $favoriteRepository,
        SerieRepository $serieRepository,
        Paginator $paginator,
        SerieProvider $serieProvider,
        SearchController $searchController,
        EpisodeHelper $episodeHelper
    ) {
        $this->serieByApiProvider = $serieByApiProvider;
        $this->serieDTOBuilder = $serieDTOBuilder;
        $this->serieFactory = $serieFactory;
        $this->serieManager = $serieManager;
        $this->favoriteRepository = $favoriteRepository;
        $this->serieRepository = $serieRepository;
        $this->paginator = $paginator;
        $this->serieProvider = $serieProvider;
        $this->searchController = $searchController;
        $this->episodeHelper = $episodeHelper;
    }

    /**
     * @Route("/", name="home.index")
     * @param Request $request
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function index(Request $request): Response
    {
        $form = $this->searchController->handleForm($request);

        $betaseries = $this->serieByApiProvider->provideMostPopularSeries();

        $series = $this->paginator->paginateSeries($betaseries, $request, SerieDTOBuilder::Index);

        return $this->render('pages/home.html.twig', [
            'series' => $series,
            'current_menu' => self::HOME,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/serie/show/{id}", name="serie.show")
     * @param string $id
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function show(string $id, Request $request): Response
    {
        $user = $this->getUser();

        $checkboxForms = null;
        $form = $this->searchController->handleForm($request);

        $serie = $this->serieByApiProvider->provideSerieByApi($id);
        $serie = $this->serieDTOBuilder->switchAndBuildSerieInfo($serie, SerieDTOBuilder::Index);

        $serieDetails = $this->episodeHelper->buildEpisodeLink($serie, $user);

        return $this->render('pages/show_serie.html.twig', [
            'serie' => $serie,
            'form' => $form->createView(),
            'serieDetails' => $serieDetails
        ]);
    }

    /**
     * @Route("/serie/add/{id}", name="serie.add")
     * @param string $id
     * @return Serie
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function add(string $id): Serie
    {
        $serieInfo = $this->serieByApiProvider->provideSerieByApi($id);
        $serie = $this->serieFactory->buildByApi($serieInfo);

        $this->serieManager->saveSerie($serie);

        return $serie;
    }

    /**
     * @Route("/serie/delete/{id}", name="serie.delete")
     * @param string $id
     * @return Void
     */
    public function delete(string $id): Void
    {
        $this->serieManager->deleteSerie($id);
    }

    /**
     * @Route("/serie/favorites", name="serie.favorites")
     * @param Request $request
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function listFavorite(Request $request): Response
    {
        $form = $this->searchController->handleForm($request);

        $user = $this->getUser();
        $favoriteSeries = $this->serieProvider->provideFavoritesSeries($user);

        $series = $this->paginator->paginateSeries($favoriteSeries, $request, SerieDTOBuilder::DoctrineSerie);

        return $this->render('pages/home.html.twig', [
            'series' => $series,
            'current_menu' => self::USER,
            'form' => $form->createView()
        ]);
    }
}