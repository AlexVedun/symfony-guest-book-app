<?php

namespace App\Service;

use App\Class\PaginationData;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PaginationService
{
    public function getPaginationData(Paginator $paginator, int $page, int $itemsPerPage): PaginationData
    {
        $maxPages = (int) round( count($paginator) / $itemsPerPage);
        $previousPage = max(($page - 1), 1);
        $nextPage = min(($page + 1), $maxPages);

        return new PaginationData($previousPage, $page, $nextPage, $maxPages);
    }
}
