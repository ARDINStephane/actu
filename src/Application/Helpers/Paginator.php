<?php

namespace App\Application\Helpers;

use App\Application\Series\DTO\SerieDTOBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Paginator
 * @package App\Application\Helpers
 */
class Paginator
{
    /**
     * @var SerieDTOBuilder
     */
    private $serieDTOBuilder;
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(
        SerieDTOBuilder $serieDTOBuilder,
        PaginatorInterface $paginator
    )
    {
        $this->serieDTOBuilder = $serieDTOBuilder;
        $this->paginator = $paginator;
    }

    public function paginateSeries(array $series, Request $request, string $tag): PaginationInterface
    {
        $paginated = [];

        foreach ($series as $serie) {
            $serieDto = $this->serieDTOBuilder->switchAndBuildSerieInfo($serie, $tag);
            if(isset($serieDto)) {
                $paginated[] = $serieDto;
            }
        }

        $paginated = $this->paginator->paginate(
            $paginated,
            $request->query->getInt('page', 1),
            12
        );

        return $paginated;
    }
}