<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class AuthRegisterData extends Data{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $password,
        public string $role
    ){}

    public static function rules(): array{
        return [
            'firstName'            => 'required|string|max:255',
            'lastName'             => 'required|string|max:255',
            'email'                => 'required|email|unique:users|max:255',
            'password'             => 'required|min:8|max:255',
            'passwordConfirmation' => 'required|min:8|same:password|max:255',
        ];
    }
}
