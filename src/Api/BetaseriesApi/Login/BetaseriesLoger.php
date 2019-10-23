<?php

namespace App\Api\BetaseriesApi\Login;


use App\Application\Helpers\OAuth2ClientProvider\Oauth2Betaseries;

/**
 * Class BetaseriesLoger
 * @package App\Api\BetaseriesApi
 */
class BetaseriesLoger
{
    /**
     * @var Oauth2Betaseries
     */
    private $provider;
    /**
     * @var TokenManager
     */
    private $tokenManager;

    /**
     * BetaseriesLoger constructor.
     * @param Oauth2Betaseries $provider
     * @param TokenManager $tokenManager
     */
    public function __construct(
        Oauth2Betaseries $provider,
        TokenManager $tokenManager
    ) {
        $this->provider = $provider;
        $this->tokenManager = $tokenManager;
    }

    /**
     * @return void
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function login(): void
    {
        if (!isset($_GET['code'])) {
            // If we don't have an authorization code then get one
            $authUrl = $this->provider->getAuthorizationUrl();

            header('Location: ' . $authUrl);
            exit;
        } else {
            // Try to get an access token (using the authorization code grant)
            $token = $this->provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            $this->tokenManager->set($token);
        }
    }
}