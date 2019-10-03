<?php

namespace App\Application\Helpers\OAuth2ClientProvider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Oauth2Betaseries
 * @package App\Application\Helpers\OAuth2ClientProvider
 */
class Oauth2Betaseries extends AbstractProvider
{
    use ArrayAccessorTrait;

    const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'user.id';

    /**
     * Returns the base URL for authorizing a client.
     *
     * @return string
     */
    public function getBaseAuthorizationUrl(): string
    {
        return 'https://www.betaseries.com/authorize';
    }

    /**
     * Returns the base URL for requesting an access token.
     *
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params): string
    {
        return 'https://api.betaseries.com/members/access_token';
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return 'https://api.betaseries.com/members/infos';
    }

    /**
     * Returns the default scopes used by this provider.
     *
     * This should only be the scopes that are required to request the details
     * of the resource owner, rather than all the available scopes.
     *
     * @return array
     */
    protected function getDefaultScopes(): array
    {
        return [];
    }

    /**
     * Checks a provider response for errors.
     *
     * @param  ResponseInterface $response
     * @param  array|string $data Parsed response data
     * @return array
     */
    protected function checkResponse(ResponseInterface $response, $data): array
    {
        return [];
    }

    /**
     * Generates a resource owner object from a successful resource owner
     * details request.
     *
     * @param  array $response
     * @param  AccessToken $token
     * @return ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token): Oauth2BetaseriesResourceOwner
    {
        return new Oauth2BetaseriesResourceOwner($response['member']);
    }

    /**
     * Prepares an parsed access token response for a grant.
     *
     * @param  mixed $result
     * @return array
     */
    protected function prepareAccessTokenResponse(array $result): array
    {
        if ($this->getAccessTokenResourceOwnerId() !== null) {
            $result['access_token'] = $this->getValueByKey(
                $result,
                'token'
            );
        }
        return parent::prepareAccessTokenResponse($result);
    }
}
