<?php

namespace App\Api\BetaseriesApi\Provider;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\CurlHttpClient;

/**
 * Class SerieByApiProvider
 * @package App\Api\BetaseriesApi\Provider
 */
class SerieByApiProvider
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
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function provideMostPopularSeries(): array
    {
        $url = 'https://api.betaseries.com/shows/list?&order=popularity&limit=120';

        $series = $this->curlRequestResults(self::GetMethod, $url);

        return $series['shows'];
    }

    /**
     * @param string $id
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function provideSerieBy(string $id): array
    {
        $url = 'https://api.betaseries.com/shows/display?id=' .$id;

        $serie = $this->curlRequestResults(self::GetMethod, $url);

        return $serie['show'];
    }

    /**
     * @param string $name
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function searchSerie(string $name): array
    {
        $url = 'https://api.betaseries.com/search/all?query=' . $name . '&limit=24';
        $series = $this->curlRequestResults(self::GetMethod, $url);

        return $series['shows'];
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