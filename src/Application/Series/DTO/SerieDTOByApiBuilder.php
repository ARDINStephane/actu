<?php

namespace App\Application\Series\DTO;


use Cocur\Slugify\Slugify;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SerieDTOByApiBuilder
{
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(
        RouterInterface $router,
        TokenStorageInterface $tokenStorage
    ) {
        $this->router = $router;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param $serie
     * @return SerieCardDTO
     */
    public function build($serie): SerieCardDTO
    {
        $id = $serie['id'];
        $title= $serie['original_title'];
        $slug = $this->slugify($title);
        $alias= $serie['aliases'];
        $images= $serie['images'];
        $year= $serie['creation'];
        $origin= $serie['language'];
        $genre= $serie['genres'];
        $numberOfSeasons= $serie['seasons'];
        $seasonsDetails= $serie['seasons_details'];
        $numberOfEpisodes= $serie['episodes'];
        $lastEpisode= $this->getLastEpisode($seasonsDetails);
        $description= $serie['description'];
        $note= $serie['notes'];
        $status= $serie['status'];
        $serieShow = $this->router->generate('serie.show', ['id' => $id]);
        $isfavorite = $this->isUsersFavorite($id);
        $toggleFavorite = $this->router->generate('toggle_favorite', ['id' => $id]);

        return new SerieCardDTO(
            $id,
            $title,
            $slug,
            $alias,
            $images,
            $year,
            $origin,
            $genre,
            $numberOfSeasons,
            $seasonsDetails,
            $numberOfEpisodes,
            $lastEpisode,
            $description,
            $note,
            $status,
            $serieShow,
            $isfavorite,
            $toggleFavorite
        );
    }

    /**
     * @param $seasonsDetails
     * @return string
     */
    protected function getLastEpisode($seasonsDetails): string
    {
        $lastSeason = end($seasonsDetails);
        if (strlen($lastSeason['episodes'] < 10)) {
            $lastSeason['episodes'] = '0' . $lastSeason['episodes'];
        }
        if (strlen($lastSeason['number'] < 10)) {
            $lastSeason['number'] = '0' . $lastSeason['number'];
        }

        return $lastEpisode = 'S' . $lastSeason['number'] . ' E' . $lastSeason['episodes'];
    }

    /**
     * @param string $title
     * @return string
     */
    protected function slugify(string $title): string
    {
        $slugify = new Slugify();

        return $slugify->slugify($title);
    }

    /**
     * @return bool
     */
    public function isUsersFavorite($serieId): bool
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if(empty($user) || $user == "anon.") {
            return false;
        }
        if(!empty($user->getFavorites())) {
            foreach ($user->getFavorites() as $favorite) {
                if($favorite->getSerie()->getId() == $serieId) {
                    return true;
                }
            }
        }
        return false;
    }
}