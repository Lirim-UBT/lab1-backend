<?php

namespace App\Services\UserService;

use App\Data\AuthRegisterData;
use App\Data\UserSearchPaginatedData;
use App\Models\User;
use App\Repositories\BaseRepository\BaseRepository;
use App\Repositories\UserRepository\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use const App\Services\AuthService\ADMIN_ROLE;
use const App\Services\AuthService\PROFESSOR_ROLE;
use const App\Services\AuthService\USER_ROLE;

class UserService implements UserServiceInterface{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository){
        $this->userRepository = $userRepository;
    }

    public function create(AuthRegisterData $registerData): ?User{
        $user = $this->userRepository->create($registerData);
    }

    public function getByEmail(string $email): ?User{
        return $this->userRepository->getByEmail($email);
    }

    public function getById(UserGetById $userByIdData): ?User{
        return $this->userRepository->getById($userByIdData->id);
    }

    public function searchProfessors(UserSearchPaginatedData $searchPaginated): ?LengthAwarePaginator{
        $searchPaginated->role = PROFESSOR_ROLE;

        return $this->userRepository->searchPaginated($searchPaginated);
    }

    public function searchStudents(UserSearchPaginatedData $searchPaginated): ?LengthAwarePaginator{
        $searchPaginated->role = USER_ROLE;

        return $this->userRepository->searchPaginated($searchPaginated);
    }

    public function searchAdmins(UserSearchPaginatedData $searchPaginated): ?LengthAwarePaginator{
        $searchPaginated->role = ADMIN_ROLE;

        return $this->userRepository->searchPaginated($searchPaginated);
    }

    public function update(int $id, UserUpdateData $updateData): ?User{
        return $this->userRepository->update($updateData);
    }
}
