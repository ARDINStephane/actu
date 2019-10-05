<?php

namespace App\Api\BetaseriesApi\Provider;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\CurlHttpClient;

/**
 * Class SeriesProvider
 * @package App\Api\BetaseriesApi\Provider
 */
class SeriesProvider
{
    /**
     * @var ParameterBagInterface
     */
    private $params;

    /**
     * SeriesProvider constructor.
     * @param ParameterBagInterface $params
     */
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function provideMostPopularSeries(): array
    {
        $clientId = $this->params->get('clientId');
        $client = new CurlHttpClient();
        $response = $client->request('GET', 'https://api.betaseries.com/shows/list?&order=popularity&limit=120&v=3.0&key=' . $clientId);

        $series = json_decode($response->getContent(), true);

        return $series['shows'];
    }

    public function provideSerieBy(string $id): array
    {
        $clientId = $this->params->get('clientId');
        $client = new CurlHttpClient();
        $response = $client->request('GET', 'https://api.betaseries.com/shows/display?id=' .$id .'&v=3.0&key=' . $clientId);

        $serie = json_decode($response->getContent(), true);

        return $serie['show'];
    }
}