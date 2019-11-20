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

    public function get()
    {
        $json = $this->client->performApiCallWithJsonResponse(Client::GETTMethod, '/search/series?name=good%2Bdoctor');
        dd($json);
    }
}