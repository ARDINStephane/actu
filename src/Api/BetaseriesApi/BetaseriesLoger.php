<?php

namespace App\Api\BetaseriesApi;


use App\Application\Helpers\OAuth2ClientProvider\Oauth2Betaseries;
use League\OAuth2\Client\Token\AccessTokenInterface;

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
     * BetaseriesLoger constructor.
     * @param Oauth2Betaseries $provider
     */
    public function __construct(
        Oauth2Betaseries $provider
    ) {
        $this->provider = $provider;
    }

    /**
     * @return AccessTokenInterface
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function login(): AccessTokenInterface
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
            return $token;
        }
    }
}