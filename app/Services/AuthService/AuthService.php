<?php

namespace App\Services\AuthService;

use App\Data\AuthLoginData;
use App\Data\AuthRefreshTokenData;
use App\Data\AuthRegisterData;
use App\Models\User;
use App\Services\JWTService\JwtServiceInterface;
use App\Services\UserService\UserServiceInterface;
use Illuminate\Auth\AuthManager;

const USER_ROLE = 1;
const PROFESSOR_ROLE = 2;
const ADMIN_ROLE = 3;

class AuthService implements AuthServiceInterface{
    private UserServiceInterface $userService;
    private JWTServiceInterface  $jwtService;
    private AuthManager          $authManager;

    public function __construct(
        UserServiceInterface $userService, JWTServiceInterface $jwtService, AuthManager $authManager
    ){
        $this->userService = $userService;
        $this->jwtService = $jwtService;
        $this->authManager = $authManager;
    }

    public function register(AuthRegisterData $registerData): ?User{
        $registerData->role = USER_ROLE;

        return $this->userService->create($registerData);
    }

    public function registerProfessor(AuthRegisterData $registerData): ?User{
        $registerData->role = PROFESSOR_ROLE;

        return $this->userService->create($registerData);
    }

    public function login(AuthLoginData $loginData): ?string{
        if(!$this->authManager->login($loginData)){
            return null;
        }

        $user = $this->userService->getByEmail($loginData->email);

        if(!$user){
            return null;
        }

        return $this->jwtService->generateToken($user->id, $user->organizationId);
    }

    public function refreshToken(string $token): ?string{
        if(!$this->authManager->login($token)){
            return null;
        }

        return $this->jwtService->refreshToken($token);
    }

    public function logout(): void{
        $this->authManager->logout();
    }
}
