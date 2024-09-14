<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller{
    public function __construct(){
        $this->middleware("auth:api", ["except" => ["login", "register"]]);
    }

    public function register(AuthRegisterRequest $request){
        $passwordHash = Hash::make($request->password);

        $params = [
            "email"    => $request->email,
            "password" => $passwordHash,
        ];

        $createUser = User::create($params);

        if($createUser){
            return response()->json(["success" => true, "message" => "Register successfully."], 200);
        }

        return response()->json(["failed" => true, "message" => "Register unsuccessfully."]);
    }

    public function login(){
        $credentials = request(["email", "password"]);

        if(!$token = auth()->attempt($credentials)){
            return response()->json(["error" => "Unauthorized"], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me(){
        return response()->json(auth()->user());
    }

    public function logout(){
        auth()->logout();

        return response()->json(["message" => "Successfully logged out"]);
    }

    public function refresh(){
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token){
        return response()->json([
            "access_token" => $token,
            "token_type"   => "bearer",
            "expires_in"   => auth()->factory()->getTTL() * 60,
        ]);
    }
}
