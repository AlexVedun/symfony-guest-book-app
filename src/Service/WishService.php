<?php

namespace App\Service;

use App\Class\Wish\OrderByLinks;
use App\Class\Wish\SortByLinks;
use Symfony\Component\Routing\RouterInterface;

class WishService
{
    public function __construct(private RouterInterface $router)
    {}

    public function getOrderByLinks(string $routeName, array $params): OrderByLinks
    {
        $ascLink = $this->router->generate($routeName, array_merge($params, ['order_by' => 'asc']));
        $descLink = $this->router->generate($routeName, array_merge($params, ['order_by' => 'desc']));

        return new OrderByLinks($ascLink, $descLink);
    }

    public function getSortByLinks(string $routeName, array $params): SortByLinks
    {
        $userNameLink = $this->router->generate($routeName, array_merge($params, ['sort_by' => 'username']));
        $emailLink = $this->router->generate($routeName, array_merge($params, ['sort_by' => 'email']));
        $createdAtLink = $this->router->generate($routeName, array_merge($params, ['sort_by' => 'created_at']));

        return new SortByLinks($userNameLink, $emailLink, $createdAtLink);
    }
}
