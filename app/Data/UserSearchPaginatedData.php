<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class UserSearchPaginatedData extends Data{
    public function __construct(
        public string $searchField,
        public string $searchValue,
        public string $role,
        public string $sortBy,
        public string $orderBy = "desc",
        public int $limit = 10
    ){}
}
