<?php

namespace App\Application\Series\Provider;

use App\Api\BetaseriesApi\Provider\SerieByApiProvider;
use App\Application\Common\Entity\User;
use App\Application\Common\Repository\SerieRepository;
use App\Application\Series\DTO\SerieDTOBuilder;

/**
 * Class SerieProvider
 * @package App\Application\Series\Provider
 */
class SerieProvider
{
    /**
     * @var SerieRepository
     */
    private $serieRepository;
    /**
     * @var SerieDTOBuilder
     */
    private $serieDTOBuilder;
    /**
     * @var SerieByApiProvider
     */
    private $serieByApiProvider;

    public function __construct(
        SerieRepository $serieRepository,
        SerieDTOBuilder $serieDTOBuilder,
        SerieByApiProvider $serieByApiProvider
)
    {
        $this->serieRepository = $serieRepository;
        $this->serieDTOBuilder = $serieDTOBuilder;
        $this->serieByApiProvider = $serieByApiProvider;
    }

    /**
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function provideFavoritesSeries($user): array
    {
        if(!isset($user)) {
            return [];
        }
        $favoritesSeriesDto = [];
        
        $favoritesSeries = $this->serieRepository->findFavoritesSeries($user);

/*        foreach($favoritesSeries as $serie) {
            $favoritesSeriesDto[] = $this->serieDTOBuilder->switchAndBuildSerieInfo($serie, $this->serieDTOBuilder::DoctrineSerie);
        }*/
        foreach($favoritesSeries as $serie) {
            $serieByApi = $this->serieByApiProvider->provideSerieByApi($serie->getId());
            $favoritesSeriesDto[] = $this->serieDTOBuilder->switchAndBuildSerieInfo($serieByApi, SerieDTOBuilder::Index);
        }

        return $favoritesSeriesDto;
    }
}