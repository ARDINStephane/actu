<?php

namespace App\Application\Helpers;

use App\Application\Series\DTO\SerieDTOByApiBuilder;
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
     * @var SerieDTOByApiBuilder
     */
    private $serieDTOByApiBuilder;
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(
        SerieDTOByApiBuilder $serieDTOByApiBuilder,
        PaginatorInterface $paginator
    )
    {
        $this->serieDTOByApiBuilder = $serieDTOByApiBuilder;
        $this->paginator = $paginator;
    }

    public function paginateSeries(array $series, Request $request, string $tag): PaginationInterface
    {
        $paginated = [];

        foreach ($series as $serie) {
            $paginated[] = $this->serieDTOByApiBuilder->switchAndBuildBetaserieInfo($serie, $tag);
        }
        $paginated = $this->paginator->paginate(
            $paginated,
            $request->query->getInt('page', 1),
            12
        );

        return $paginated;
    }
}