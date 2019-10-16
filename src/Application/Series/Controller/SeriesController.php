<?php

namespace App\Application\Series\Controller;


use App\Api\BetaseriesApi\Provider\SeriesProvider;
use App\Application\Common\Controller\BaseController;
use App\Application\Common\Repository\FavoriteRepository;
use App\Application\Common\Repository\SerieRepository;
use App\Application\Series\DTO\SerieCardDTO;
use App\Application\Series\DTO\SerieDTOByApiBuilder;
use App\Application\Series\Factory\SerieFactory;
use App\Application\Series\Manager\serieManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SeriesController
 * @package App\Application\Series\Controller
 */
class SeriesController extends BaseController
{
    /**
     * @var SeriesProvider
     */
    private $seriesProvider;
    /**
     * @var SerieDTOByApiBuilder
     */
    private $serieDTOByApiBuilder;
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

    public function __construct(
        SeriesProvider $seriesProvider,
        SerieDTOByApiBuilder $serieDTOByApiBuilder,
        SerieFactory $serieFactory,
        serieManager $serieManager,
        FavoriteRepository $favoriteRepository,
        SerieRepository $serieRepository
    ) {
        $this->seriesProvider = $seriesProvider;
        $this->serieDTOByApiBuilder = $serieDTOByApiBuilder;
        $this->serieFactory = $serieFactory;
        $this->serieManager = $serieManager;
        $this->favoriteRepository = $favoriteRepository;
        $this->serieRepository = $serieRepository;
    }

    /**
     * @Route("/", name="home.index")
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $series = [];
        $betaseries = $this->seriesProvider->provideMostPopularSeries();

        foreach ($betaseries as $betaserie) {
            $series[] = $this->serieDTOByApiBuilder->build($betaserie);
        }
        $series = $paginator->paginate(
            $series,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('pages/home.html.twig', [
            'series' => $series
        ]);
    }

    /**
     * @Route("/serie/{id}", name="serie.show")
     * @param string $id
     * @return Response
     */
    public function show(string $id): Response
    {
        $serie = $this->seriesProvider->provideSerieBy($id);
        $serie = $this->serieDTOByApiBuilder->build($serie);

        return $this->render('serie/_serie.html.twig', [
            'serie' => $serie
        ]);
    }

    /**
     * @Route("/serie/add/{id}", name="serie.add")
     * @param string $id
     * @return Void
     */
    public function add(string $id): Void
    {
        $serieInfo = $this->seriesProvider->provideSerieBy($id);
        $serie = $this->serieFactory->buildByApi($serieInfo);

        $this->serieManager->saveSerie($serie);
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
     * @Route("/toggle_favorite/{id}}", name="toggle_favorite")
     */
    public function toggleFavorite(string $id)
    {
        $serie = $this->findByRepository($this->serieRepository,$id);
        $user = $this->getUser();
        $favorite = $this->favoriteRepository->getFavorite($user, $id);

        if ($favorite == null) {
            if(empty($serie)) {
                $this->add($id);
            }
            $favorite = $this->favoriteRepository->new($user, $serie);
            $this->favoriteRepository->save($favorite);
        } else {
            $favorite->removeFromAssociations($user, $serie);
            $this->favoriteRepository->delete($favorite->getId());
            $this->delete($id);
        }
        return $this->redirectToRoute('home.index');
    }
}