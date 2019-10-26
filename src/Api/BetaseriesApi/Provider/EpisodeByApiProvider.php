<?php

namespace App\Api\BetaseriesApi\Provider;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\CurlHttpClient;

/**
 * Class SerieByApiProvider
 * @package App\Api\BetaseriesApi\Provider
 */
class EpisodeByApiProvider extends ApiProvider
{
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
     * @param string $episodeNumber
     * @param string $serieId
     * @param string $seasonNumber
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function provideEpisodeByApi(string $episodeNumber, string $serieId, string $seasonNumber): array
    {
        $url = 'https://api.betaseries.com/shows/episodes?id=' . $serieId . '&episode=' . $episodeNumber . '&season=' . $seasonNumber;
        $episode = $this->curlRequestResults(self::GetMethod, $url);

        return $episode['episodes'][0];
    }
}