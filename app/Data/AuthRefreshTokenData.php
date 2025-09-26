<?php

namespace App\Data;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class AuthRefreshTokenData extends Data
{
    public function __construct(
        public string $token,
    ) {}

    public  static function rules(): array{
        return [
            'token' => 'required|string',
        ];
    }
}
