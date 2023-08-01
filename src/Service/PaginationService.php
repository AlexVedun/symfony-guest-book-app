<?php

namespace App\Service;

use App\Class\PaginationData;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Routing\RouterInterface;

class PaginationService
{
    public function __construct(private RouterInterface $router)
    {}

    public function getPaginationData(
        Paginator $paginator,
        int $page,
        int $itemsPerPage,
        string $routeName = null,
        array $params = []
    ): PaginationData {
        $maxPages = (int) round( count($paginator) / $itemsPerPage);
        $previousPage = max(($page - 1), 1);
        $nextPage = min(($page + 1), $maxPages);

        $previousLink = $routeName
            ? $this->router->generate($routeName, array_merge($params, ['page' => $previousPage]))
            : null;
        $nextLink = $routeName
            ? $this->router->generate($routeName, array_merge($params, ['page' => $nextPage]))
            : null;
        $pageLinks = null;
        if ($routeName) {
            $pageLinks = [];
            for ($i = 1; $i <= $maxPages; $i++) {
                $pageLinks[$i] = $this->router->generate($routeName, array_merge($params, ['page' => $i]));
            }
        }

        return new PaginationData(
            $previousPage,
            $page,
            $nextPage,
            $maxPages,
            $previousLink,
            $nextLink,
            $pageLinks
        );
    }
}
