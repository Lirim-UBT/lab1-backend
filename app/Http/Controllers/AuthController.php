<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRegisterRequest;
use App\Http\Responses\ResponseBuilder;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller{
    public function register(AuthRegisterRequest $request): JsonResponse{
        $passwordHash = Hash::make($request->password);

        $params = [
            "email"    => $request->email,
            "password" => $passwordHash,
        ];

        $createUser = User::create($params);

        $responseBuilder = new ResponseBuilder();

        if($createUser){
            return $responseBuilder->status(200, false, "registeredSuccessfully")->build();
        }

        return $responseBuilder->status(400, false, "registrationFailed")->build();
    }

    public function login(): JsonResponse{
        $credentials = request(["email", "password"]);

        $responseBuilder = new ResponseBuilder();
        if(!$token = auth()->attempt($credentials)){
            return $responseBuilder->status(401, false, "loginFailed")->build();
        }

        $responseData = $this->respondWithToken($token);

        return $responseBuilder->status(200, false, "loginSuccessful")->data($responseData)->build();
    }

    public function me(): JsonResponse{
        return (new ResponseBuilder())->status(200, false, "gatheredAuthenticatedUser")->data(auth()->user())->build();
    }

    public function logout(): JsonResponse{
        auth()->logout();

        return (new ResponseBuilder())->status(200, false, "successfullyLoggedOut");
    }

    public function refresh(): JsonResponse{
        $refreshedToken = auth()->refresh();
        $responseData = $this->respondWithToken($refreshedToken);

        return (new ResponseBuilder())->status(200, false, "refreshedAuthToken")->data($responseData)->build();
    }

    private function respondWithToken($token): array{
        return [
            "access_token" => $token,
            "token_type"   => "bearer",
            "expires_in"   => auth()->factory()->getTTL() * 60,
        ];
    }
}
