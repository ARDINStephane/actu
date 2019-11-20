<?php

namespace App\Api\TheTvDbApi\Login;


use League\OAuth2\Client\Token\AccessTokenInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class TokenManager
 * @package App\Api\BetaseriesApi
 */
class TokenManager
{
    const KEY = 'token';
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * TokenManager constructor.
     * @param SessionInterface $session
     */
    public function __construct(
        SessionInterface $session
    ) {
        $this->session = $session;
    }

    /**
     * @param string $token
     */
    public function set(string $token): void
    {
        $this->session->set(self::KEY , $token);
    }

    /**
     * @return AccessTokenInterface|null
     */
    public function get(): ?string
    {
        return $this->session->get(self::KEY);
    }
}