<?php

namespace App\Api\BetaseriesApi\Controller;


use App\Api\BetaseriesApi\Login\BetaseriesLoger;
use App\Api\BetaseriesApi\Login\TokenManager;
use App\Application\Common\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BetaseriesApiSecurityController
 * @package App\Api\BetaseriesApi\Controller
 */
class BetaseriesApiSecurityController extends BaseController
{
    /**
     * @Route("/betaseries", name="betaseries.login")
     * @param BetaseriesLoger $logger
     * @return Response
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function login(BetaseriesLoger $logger): Response
    {
        $logger->login();

        try {
            return $this->redirectToRoute('betaseries.test');
        } catch (\Exception $e) {
            exit('Oh mince...');
        }
    }

    /**
     * @Route("/betaseries/test", name="betaseries.test")
     * @param TokenManager $tokenManager
     */
    public function executeRequest(TokenManager $tokenManager)
    {
        $token = $tokenManager->get();
        dd($token);
    }
}