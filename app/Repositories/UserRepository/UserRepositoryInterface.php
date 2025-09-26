<?php

namespace App\Repositories\UserRepository;

use App\Data\UserSearchPaginatedData;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserRepositoryInterface{
    public function getById(int $id): ?User;

    public function getByEmail(string $email): ?Model;

    public function searchPaginated(UserSearchPaginatedData $parameters): ?LengthAwarePaginator;
}




