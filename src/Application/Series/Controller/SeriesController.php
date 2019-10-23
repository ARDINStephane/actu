<?php

namespace App\Application\Series\Controller;


use App\Api\BetaseriesApi\Provider\SeriesProvider;
use App\Application\Common\Controller\BaseController;
use App\Application\Series\DTO\SerieCardDTO;
use App\Application\Series\DTO\SerieDTOByApiBuilder;
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

    public function __construct(
        SeriesProvider $seriesProvider,
        SerieDTOByApiBuilder $serieDTOByApiBuilder
    ) {
        $this->seriesProvider = $seriesProvider;
        $this->serieDTOByApiBuilder = $serieDTOByApiBuilder;
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
     * @param $id
     */
    public function show(string $id)
    {
        $serie = $this->seriesProvider->provideSerieBy($id);
        $serie = $this->serieDTOByApiBuilder->build($serie);

        return $this->render('serie/_serie.html.twig', [
            'serie' => $serie
        ]);
    }
}