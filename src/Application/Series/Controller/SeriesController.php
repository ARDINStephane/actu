<?php

namespace App\Application\Series\Controller;


use App\Api\BetaseriesApi\Provider\SeriesProvider;
use App\Application\Common\Controller\BaseController;
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

    public function __construct(
        SeriesProvider $seriesProvider
    ) {
        $this->seriesProvider = $seriesProvider;
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
        $series = $paginator->paginate(
            $this->seriesProvider->provideMostPopularSeries(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('pages/home.html.twig', [
            'series' => $series
        ]);
    }
}