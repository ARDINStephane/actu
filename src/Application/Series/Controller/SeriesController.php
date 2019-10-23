<?php

namespace App\Application\Series\Controller;


use App\Api\BetaseriesApi\Provider\SerieByApiProvider;
use App\Application\Common\Controller\BaseController;
use App\Application\Common\Entity\Serie;
use App\Application\Common\Repository\FavoriteRepository;
use App\Application\Common\Repository\SerieRepository;
use App\Application\Helpers\Paginator;
use App\Application\Search\Entity\Search;
use App\Application\Series\DTO\SerieDTOBuilder;
use App\Application\Series\Factory\SerieFactory;
use App\Application\Series\Manager\serieManager;
use App\Application\Search\Form\SearchType;
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
    const Home = "home";
    const Favorites = "favorites";
    /**
     * @var SerieByApiProvider
     */
    private $serieByApiProvider;
    /**
     * @var SerieDTOBuilder
     */
    private $SerieDTOBuilder;
    /**
     * @var SerieFactory
     */
    private $serieFactory;
    /**
     * @var serieManager
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

    public function __construct(
        SerieByApiProvider $serieByApiProvider,
        SerieDTOBuilder $SerieDTOBuilder,
        SerieFactory $serieFactory,
        serieManager $serieManager,
        FavoriteRepository $favoriteRepository,
        SerieRepository $serieRepository,
        Paginator $paginator,
        SerieProvider $serieProvider
    ) {
        $this->serieByApiProvider = $serieByApiProvider;
        $this->SerieDTOBuilder = $SerieDTOBuilder;
        $this->serieFactory = $serieFactory;
        $this->serieManager = $serieManager;
        $this->favoriteRepository = $favoriteRepository;
        $this->serieRepository = $serieRepository;
        $this->paginator = $paginator;
        $this->serieProvider = $serieProvider;
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
        $form = $this->handleForm($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();

            return $this->redirectToRoute('serie.search', [
                'search' => $search->getName()
            ]);
        }
        $betaseries = $this->serieByApiProvider->provideMostPopularSeries();

        $series = $this->paginator->paginateSeries($betaseries, $request, SerieDTOBuilder::Index);

        return $this->render('pages/home.html.twig', [
            'series' => $series,
            'current_menu' => self::Home,
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
    public function show(string $id): Response
    {
        $serie = $this->serieByApiProvider->provideSerieBy($id);
        $serie = $this->SerieDTOBuilder->switchAndBuildSerieInfo($serie, SerieDTOBuilder::Index);

        return $this->render('serie/_serie.html.twig', [
            'serie' => $serie
        ]);
    }

    /**
     * @Route("/serie/add/{id}", name="serie.add")
     * @param string $id
     * @return Void
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function add(string $id): Serie
    {
        $serieInfo = $this->serieByApiProvider->provideSerieBy($id);
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
     * @Route("/serie/search/{search}", name="serie.search")
     * @param string $search
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function search(string $search, Request $request): Response
    {
        $form = $this->handleForm($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();

            return $this->redirectToRoute('serie.search', [
                'search' => $search->getName()
            ]);
        }

        $betaseries = $this->serieByApiProvider->searchSerie($search);
        $series = $this->paginator->paginateSeries($betaseries, $request, SerieDTOBuilder::Search);

        return $this->render('pages/home.html.twig', [
            'series' => $series,
            'search' => $search,
            'current_menu' => self::Home,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function handleForm(Request $request)
    {
        $newSearch = new Search();
        $form = $this->createForm(SearchType::class, $newSearch);
        $form->handleRequest($request);

        return $form;
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
        $form = $this->handleForm($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();

            return $this->redirectToRoute('serie.search', [
                'search' => $search->getName()
            ]);
        }
        $favoriteSeries = $this->serieProvider->provideFavoritesSeries();

        $series = $this->paginator->paginateSeries($favoriteSeries, $request, SerieDTOBuilder::DoctrineSerie);

        return $this->render('pages/home.html.twig', [
            'series' => $series,
            'current_menu' => self::Favorites,
            'form' => $form->createView()
        ]);
    }
}