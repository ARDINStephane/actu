<?php

namespace App\Application\Episodes\Helpers;

use App\Api\BetaseriesApi\Provider\SerieByApiProvider;
use App\Application\Common\Entity\Favorite;
use App\Application\Common\Repository\FavoriteRepository;
use App\Application\Series\DTO\SerieCardDTO;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class EpisodesHelper
 * @package App\Application\Episodes\Helpers
 */
class EpisodeHelper
{
    /**
     * @var FavoriteRepository
     */
    private $favoriteRepository;
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var SerieByApiProvider
     */
    private $serieByApiProvider;

    public function __construct(
        FavoriteRepository $favoriteRepository, TranslatorInterface $translator,
        SerieByApiProvider $serieByApiProvider
    ) {
        $this->favoriteRepository = $favoriteRepository;
        $this->translator = $translator;

        $this->serieByApiProvider = $serieByApiProvider;
    }

    /**
     * @param string $seasonNumber
     * @param string $episodeNumber
     * @return string
     */
    public function buildEpisodeCode(string $seasonNumber, string $episodeNumber): string
    {
        if (strlen($episodeNumber < 10)) {
            $episodeNumber = '0' . $episodeNumber;
        }
        if (strlen($seasonNumber < 10)) {
            $seasonNumber = '0' . $seasonNumber;
        }

        return $lastEpisode = 'S' . $seasonNumber . 'E' . $episodeNumber;
    }

    /**
     * @param Favorite $favorite
     * @param string $seasonNumber
     * @return array
     */
    public function getSeasonAllEpisodesCode(Array $seasonDetails, string $seasonNumber): array
    {
        $seasonRank = $seasonNumber - 1;
        $episodes = [];

        for ($i = 1; $i <= $seasonDetails[$seasonRank]['episodes']; $i++) {
            $episodeCode = $this->buildEpisodeCode($seasonNumber, $i);
            $episodes[] = $episodeCode;
        }

        return $episodes;
    }

    /**
     * @param Favorite $favorite
     * @param array $fullSeason
     * @return array
     */
    public function getNotSeenEpisodesCode(Favorite $favorite, array $fullSeason)
    {
        $notSeenEpisodes = [];

        foreach ($fullSeason as $episode) {
            if (!$favorite->isEpisodeSeen($episode)) {
                $notSeenEpisodes[] = $episode;
            }
        }

        return $notSeenEpisodes;
    }



    /**
     * @param SerieCardDTO $serieCardDTO
     * @return array
     */
    public function buildEpisodeLink(SerieCardDTO $serieCardDTO, $user): array
    {
        $serie['serieId'] = [$serieCardDTO->getId()];
        $favorite = $this->favoriteRepository->getFavorite($user, $serieCardDTO->getId());

        foreach ($serieCardDTO->getSeasonsDetails() as $season) {
            $seasonNumber = $season['number'];

            $seasonSeen = $this->translator->trans('episode.allSeen');
            if (empty($favorite)) {
                $seasonSeen = $this->translator->trans('episode.seeAll');
            }

            for ($i = 1; $i <= $season['episodes']; $i++) {
                $episodeCode = $this->buildEpisodeCode($seasonNumber, $i);

                $episode = [
                    'season' => $seasonNumber,
                    'episode' => $i,
                    'code' => $episodeCode,
                    'seen' => $this->translator->trans('episode.toSee')
                ];
                $this->translator->trans('episode.toSee');
                if(!empty($favorite)) {
                    $checkSeen = $favorite->isEpisodeSeen($episodeCode);
                    if ($checkSeen) {
                        $seen = $this->translator->trans('episode.seen');
                    } else {
                        $seen = $this->translator->trans('episode.toSee');
                        $seasonSeen = $this->translator->trans('episode.seeAll');
                    }
                    $episode['seen'] = $seen;
                }

                $serie['seasons'][$seasonNumber][] = $episode;
            }
            $serie['seasons'][$seasonNumber][0]['seasonNumber'] = $seasonNumber;
            $serie['seasons'][$seasonNumber][0]['seasonSeen'] = $seasonSeen;
        }

        return $serie;
    }
}