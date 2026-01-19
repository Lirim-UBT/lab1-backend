<?php

namespace App\Services\AuthService;

use App\Data\AuthLoginData;
use App\Data\AuthRegisterData;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;

interface AuthServiceInterface{
    public function register(AuthRegisterData $registerData): ?User;

    public function login(AuthLoginData $loginData): ?string;

    public function refreshToken(string $token): ?string;

    public function logout(): void;
}
