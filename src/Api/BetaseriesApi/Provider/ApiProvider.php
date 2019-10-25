<?php

namespace App\Api\BetaseriesApi\Provider;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\CurlHttpClient;

/**
 * Class ApiProvider
 * @package App\Api\BetaseriesApi\Provider
 */
class ApiProvider
{
    const GetMethod = 'GET';
    /**
     * @var ParameterBagInterface
     */
    private $params;

    /**
     * SerieByApiProvider constructor.
     * @param ParameterBagInterface $params
     */
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @param string $method
     * @param string $url
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    protected function curlRequestResults(string $method, string $url): array
    {
        $clientId = $this->params->get('clientId');
        $client = new CurlHttpClient();
        $response = $client->request($method, $url . '&v=3.0&key=' . $clientId);

        return json_decode($response->getContent(), true);
    }
}