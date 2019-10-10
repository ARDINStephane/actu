<?php

namespace App\Application\Series\Controller;


use App\Api\BetaseriesApi\Provider\SeriesProvider;
use App\Application\Common\Controller\BaseController;
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

    public function __construct(
        SeriesProvider $seriesProvider,
        SerieDTOByApiBuilder $serieDTOByApiBuilder,
        SerieFactory $serieFactory,
        serieManager $serieManager
    ) {
        $this->seriesProvider = $seriesProvider;
        $this->serieDTOByApiBuilder = $serieDTOByApiBuilder;
        $this->serieFactory = $serieFactory;
        $this->serieManager = $serieManager;
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
     * @return Response
     */
    public function add(string $id): Response
    {
        $serieInfo = $this->seriesProvider->provideSerieBy($id);
        $serie = $this->serieFactory->buildByApi($serieInfo);

        $this->serieManager->saveSerie($serie);

        return $this->redirectToRoute("home.index");
    }

    /**
     * @Route("/serie/delete/{id}", name="serie.delete")
     * @param string $id
     * @return Response
     */
    public function delete(string $id): Response
    {
        $this->serieManager->deleteSerie($id);

        return $this->redirectToRoute("home.index");
    }
}