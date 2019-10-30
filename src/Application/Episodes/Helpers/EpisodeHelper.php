<?php

namespace App\Application\Episodes\Helpers;

use App\Application\Common\Entity\Favorite;
use App\Application\Common\Repository\FavoriteRepository;
use App\Application\Series\DTO\SerieCardDTO;

/**
 * Class EpisodesHelper
 * @package App\Application\Episodes\Helpers
 */
class EpisodeHelper
{
    const TOSEE = " A voir";
    const SEEALL = " Tout voir";
    const SEEN = " Vu";
    const ALLSEEN = " Tout vu";
    /**
     * @var FavoriteRepository
     */
    private $favoriteRepository;

    public function __construct(
        FavoriteRepository $favoriteRepository
    ) {
        $this->favoriteRepository = $favoriteRepository;
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
    public function getSeasonAllEpisodesCode(Favorite $favorite, string $seasonNumber): array
    {
        $seasonRank = $seasonNumber - 1;
        $episodes = [];

        $seasonDetails = $favorite->getSerie()->getSeasonsDetails();
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

            $seasonSeen = self::ALLSEEN;
            if (empty($favorite)) {
                $seasonSeen = self::SEEALL;
            }

            for ($i = 1; $i <= $season['episodes']; $i++) {
                $episodeCode = $this->buildEpisodeCode($seasonNumber, $i);

                $episode = [
                    'season' => $seasonNumber,
                    'episode' => $i,
                    'code' => $episodeCode,
                    'seen' => self::TOSEE
                ];

                if(!empty($favorite)) {
                    $checkSeen = $favorite->isEpisodeSeen($episodeCode);
                    if ($checkSeen) {
                        $seen = self::SEEN;
                    } else {
                        $seen = self::TOSEE;
                        $seasonSeen = self::SEEALL;
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