<?php

namespace App\Http\Controllers;

use App\Data\AuthLoginData;
use App\Data\AuthRefreshTokenData;
use App\Data\AuthRegisterData;
use App\Http\Responses\ResponseBuilder;
use App\Services\AuthService\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller{
    private AuthServiceInterface     $authService;
    private ResponseBuilderInterface $responseBuilder;

    public function __construct(AuthServiceInterface $authService, ResponseBuilderInterface $responseBuilder){
        $this->authService = $authService;
        $this->responseBuilder = $responseBuilder;
    }

    public function register(AuthRegisterData $registerData): JsonResponse{
        $passwordHash = Hash::make($registerData->password);

        $registerData->password = $passwordHash;

        $createUser = $this->authService->register($registerData);

        $responseBuilder = new ResponseBuilder();

        if($createUser){
            return $responseBuilder->status(200, false, "registeredSuccessfully")->build();
        }

        return $responseBuilder->status(400, false, "registrationFailed")->build();
    }

    public function login(AuthLoginData $loginData): JsonResponse{
        $responseBuilder = new ResponseBuilder();

        $token = $this->authService->login($loginData);

        if(!$token){
            return $responseBuilder->status(401, false, "loginFailed")->build();
        }

        $responseData = $this->respondWithToken($token);

        return $responseBuilder->status(200, false, "loginSuccessful")->data($responseData)->build();
    }

    public function logout(): JsonResponse{
        $this->authService->logout();

        return (new ResponseBuilder())->status(200, false, "successfullyLoggedOut")->build();
    }

    public function refresh(AuthRefreshTokenData $refreshTokenData): JsonResponse{
        $token = $this->authService->refreshToken($refreshTokenData->token);

        $responseBuilder = new ResponseBuilder();

        if(!$token){
            return $responseBuilder->status(404, false, "invalidToken")->build();
        }

        $responseData = $this->respondWithToken($token);

        return $responseBuilder->status(200, false, "refreshedAuthToken")->data($responseData)->build();
    }

    private function respondWithToken($token): array{
        return [
            "access_token" => $token,
            "token_type"   => "bearer",
            "expires_in"   => auth()->factory()->getTTL() * 60,
        ];
    }
}
