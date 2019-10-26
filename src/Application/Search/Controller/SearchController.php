<?php

namespace App\Application\Search\Controller;


use App\Api\BetaseriesApi\Provider\SerieByApiProvider;
use App\Application\Common\Controller\BaseController;
use App\Application\Helpers\Paginator;
use App\Application\Search\Entity\Search;
use App\Application\Search\Form\SearchType;
use App\Application\Search\Helper\SearchHelper;
use App\Application\Series\Controller\SeriesController;
use App\Application\Series\DTO\SerieDTOBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchController
 * @package App\Application\Search\Controller
 */
class SearchController extends BaseController
{
    /**
     * @var SerieByApiProvider
     */
    private $serieByApiProvider;
    /**
     * @var Paginator
     */
    private $paginator;

    public function __construct(
        SerieByApiProvider $serieByApiProvider,
        Paginator $paginator
    )
    {
        $this->serieByApiProvider = $serieByApiProvider;
        $this->paginator = $paginator;
    }

    /**
     * @Route("/serie/search/", name="serie.search")
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function search(Request $request): Response
    {

        $form = $this->handleForm($request);
        $search = $request->query->get('search');

        $betaseries = $this->serieByApiProvider->searchSerie($search);
        $series = $this->paginator->paginateSeries($betaseries, $request, SerieDTOBuilder::Search);

        return $this->render('pages/home.html.twig', [
            'series' => $series,
            'search' => $search,
            'current_menu' => SeriesController::Home,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     */
    public function handleForm(Request $request)
    {
        $newSearch = new Search();
        $form = $this->createForm(SearchType::class, $newSearch);
        $form->handleRequest($request);

        return $form;
    }
}