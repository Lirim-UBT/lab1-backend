<?php

namespace App\Services\JWTService;

use App\Services\AuthService\AuthServiceInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService implements JwtServiceInterface{
    private string $secretKey;
    private string $algorithm = 'HS256';
    private int    $ttlDays   = 60;

    public function __construct(){
        $this->secretKey = config('app.jwt_secret') ?: config('app.key');
    }

    public function generateToken(int $userId, int $organizationId): string{
        $payload = [
            'iss'             => config('app.url'),
            'aud'             => config('app.url'),
            'iat'             => time(),
            'exp'             => time() + ($this->ttlDays * 24 * 60 * 60),
            'sub'             => $userId,
            'user_id'         => $userId,
            'organization_id' => $organizationId,
            'jti'             => uniqid(),
        ];

        return JWT::encode($payload, $this->secretKey, $this->algorithm);
    }

    public function validateToken(string $token): ?object{
        try{
            return JWT::decode($token, new Key($this->secretKey, $this->algorithm));
        } catch(\Exception $e){
            return null;
        }
    }

    public function refreshToken(string $token): ?string{
        $decoded = $this->validateToken($token);

        if(!$decoded){
            return null;
        }

        return $this->generateToken($decoded->user_id, $decoded->organization_id);
    }
}
