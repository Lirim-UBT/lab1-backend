<?php

namespace App\Services\JWTService;

interface JwtServiceInterface{
    public function generateToken(int $userId, int $organizationId): string;

    public function validateToken(string $token): ?object;

    public function refreshToken(string $token): ?string;
}
