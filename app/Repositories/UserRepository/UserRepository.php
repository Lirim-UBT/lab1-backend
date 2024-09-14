<?php

namespace App\Repositories\UserRepository;

use App\Models\User;
use App\Repositories\BaseRepository\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface{
    public function __construct(User $model){
        parent::__construct($model);
    }

    public function getByEmail(string $email): Model|null{
        return $this->model->query()
                           ->with("organization")
                           ->where("email", $email)
                           ->first();
    }
}
