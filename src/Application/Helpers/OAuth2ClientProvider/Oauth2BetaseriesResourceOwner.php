<?php

namespace App\Application\Helpers\OAuth2ClientProvider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * Class Oauth2BetaseriesResourceOwner
 * @package App\Application\Helpers\OAuth2ClientProvider
 */
class Oauth2BetaseriesResourceOwner implements ResourceOwnerInterface
{
    /**
     * Raw response
     * @var array
     */
    protected $response;

    /**
     * Creates new resource owner.
     * @param array  $response
     */
    public function __construct(array $response = array())
    {
        $this->response = $response;
    }

    /**
     * Get resource owner id
     * @return array
     */
    public function getId(): array
    {
        return $this->response['id'] ?: null;
    }

    /**
     * Return all of the owner details available as an array.
     * @return array
     */
    public function toArray(): array
    {
        return $this->response;
    }
}