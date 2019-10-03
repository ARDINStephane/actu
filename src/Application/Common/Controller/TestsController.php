<?php

namespace App\Application\Common\Controller;


use App\Api\BetaseriesApi\BetaseriesLoger;
use App\Application\Helpers\OAuth2ClientProvider\Oauth2Betaseries;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpFoundation\Request;
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
     */
    public function index(BetaseriesLoger $logger): Response
    {
        $token = $logger->login();

        try {
            return $this->redirectToRoute('home.executerequest', ['token' => $token]);
        } catch (\Exception $e) {
            exit('Oh mince...');
        }

    }

    /**
     * @Route("/{token}", name="home.executerequest")
     */
    public function executeRequest($token)
    {
        dd($token);
    }
}