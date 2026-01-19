<?php

namespace App\Repositories\UserRepository;

use App\Data\SearchParametersData;
use App\Data\UserSearchPaginatedData;
use App\Models\User;
use App\Repositories\BaseRepository\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use const App\Services\AuthService\ADMIN_ROLE;
use const App\Services\AuthService\PROFESSOR_ROLE;
use const App\Services\AuthService\USER_ROLE;

class UserRepository extends BaseRepository implements UserRepositoryInterface{
    public function __construct(User $model){
        parent::__construct($model);
    }

    public function getByEmail(string $email): ?User{
        try{
            return $this->model->query()
                               ->where("email", $email)
                               ->first();
        } catch(\Exception $e){
            return null;
        }
    }

    public function getById(int $id): ?User{
        try{
            return $this->model->query()->where("id", $id)->first();
        } catch(\Exception $e){
            return null;
        }
    }

    public function searchPaginated(UserSearchPaginatedData $parameters): ?LengthAwarePaginator{
        try{
            $query = $this->model->query()->where("role", $parameters->role);

            if($parameters->searchField && $parameters->searchValue){
                $query->where("{$parameters->searchField}", "ILIKE", "%{$parameters->searchValue}%");
            }

            if($parameters->sortBy){
                $query->orderBy($parameters->sortBy, $parameters->orderBy);
            }

            return $query->paginate($parameters->limit);
        } catch(\Exception $e){
            return null;
        }
    }
}
