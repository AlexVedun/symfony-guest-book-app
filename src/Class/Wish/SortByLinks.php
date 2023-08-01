<?php

namespace App\Class\Wish;

class SortByLinks
{
    public function __construct(
        public string $userNameLink,
        public string $emailLink,
        public string $createdAtLink
    ) {}
}
