<?php

namespace App\Class;

class PaginationData
{
    public function __construct(
        public int $previous,
        public int $current,
        public int $next,
        public int $max,
        public ?string $previousLink = null,
        public ?string $nextLink = null,
        public ?array $pageLinks = null,
    ) {}
}
