<?php

namespace App\Services\UserService;

use App\Data\AuthRegisterData;
use App\Models\User;
use App\Repositories\BaseRepository\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface UserServiceInterface{
    public function create(AuthRegisterData $registerData): ?User;

    public function getByEmail(string $email): ?User;

    public function getProfessors(): Collection;

    public function getStudents(): Collection;

    public function update(int $id, UserUpdateData $updateData): ?User;
}
