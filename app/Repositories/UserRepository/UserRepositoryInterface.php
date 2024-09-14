<?php

namespace App\Repositories\UserRepository;

use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface{
    public function getByEmail(string $email): Model|null;
}
