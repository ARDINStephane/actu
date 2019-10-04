<?php

namespace App\Application\Common\Controller;


use App\Api\BetaseriesApi\Login\BetaseriesLoger;
use App\Api\BetaseriesApi\Login\TokenManager;
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
     * @Route("/", name="home.index")
     * @param BetaseriesLoger $logger
     * @return Response
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function index(BetaseriesLoger $logger): Response
    {
        $logger->login();

        try {
            return $this->redirectToRoute('home.executerequest');
        } catch (\Exception $e) {
            exit('Oh mince...');
        }

    }

    /**
     * @Route("/request", name="home.executerequest")
     * @param TokenManager $tokenManager
     */
    public function executeRequest(TokenManager $tokenManager)
    {
        $token = $tokenManager->get();
        dd($token);
    }
}