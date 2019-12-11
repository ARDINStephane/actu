<?php

namespace App\Api\TheTvDbApi\Provider;


use App\Api\TheTvDbApi\Client;

/**
 * Class ApiProvider
 * @package App\Api\BetaseriesApi\Provider
 */
class ApiProvider
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(
        Client $client
    ) {

        $this->client = $client;
    }

    public function search(string $path): array
    {
        $results = $this->client->performApiCallWithJsonResponse(Client::GETMethod, $path);

        return end($results['data']);
    }
}