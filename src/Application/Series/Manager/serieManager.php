<?php

namespace App\Application\Series\Manager;


use App\Application\Common\Entity\Serie;
use App\Application\Common\Repository\SerieRepository;

class serieManager
{
    /**
     * @var SerieRepository
     */
    private $serieRepository;

    public function __construct(
        SerieRepository $serieRepository
    ) {
        $this->serieRepository = $serieRepository;
    }

    /**
     * @param Serie $serie
     */
    public function saveSerie(Serie $serie): void
    {
        $check = $this->serieRepository->findBy(['slug' => $serie->getSlug()]);

        if(!empty($check)) {
            return;
        }

        $this->serieRepository->save($serie);
    }

    /**
     * @param string $id
     */
    public function deleteSerie(string $id): void
    {
        $result = $this->serieRepository->findOneBy(['id' => $id]);

        if(empty($result)) {
            return;
        }

        $this->serieRepository->delete($result->getId());
    }
}