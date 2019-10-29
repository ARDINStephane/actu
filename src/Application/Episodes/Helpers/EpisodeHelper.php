<?php

namespace App\Application\Episodes\Helpers;

/**
 * Class EpisodesHelper
 * @package App\Application\Episodes\Helpers
 */
class EpisodeHelper
{
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
}