<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class AuthLoginData extends Data implements \Illuminate\Contracts\Auth\Authenticatable{
    public function __construct(
        public string $email,
        public string $password,
    ){}

    public static function rules(): array{
        return [
            'email'    => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ];
    }
}
