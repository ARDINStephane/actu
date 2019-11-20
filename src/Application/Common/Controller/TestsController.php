<?php

namespace App\Application\Common\Controller;


use App\Api\BetaseriesApi\Login\BetaseriesLoger;
use App\Api\TheTvDbApi\Login\TheTvDbApiLogger;
use App\Api\TheTvDbApi\Login\TokenManager;
use App\Api\TheTvDbApi\Provider\ApiProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TestsController
 * @package App\Application\Common\Controller
 */
class TestsController extends BaseController
{
    /**
     * @var string
     */
    protected $yes = 'yes ça marche';
    /**
     * @var string
     */
    protected $cool = "Cool on va bien s'amuser";

    /**
     * @Route("/test", name="test.index")
     * @return Response
     */
    public function index(TokenManager $tokenManager, ApiProvider $apiProvider): Response
    {
        $apiProvider->get();

        return $this->render('test/test.html.twig',[
            'yes' =>$this->yes,
            'cool' => $this->cool
        ]);
    }
}