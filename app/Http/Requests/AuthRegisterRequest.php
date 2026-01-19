<?php

namespace App\Http\Requests;

class AuthRegisterRequest extends BaseRequest{
    protected array $expectedParameters = ["firstName", "lastName", "email", "password", "passwordConfirmation"];

    public function rules(): array{
        return [
            "firstName"            => "required|string|max:255",
            "lastName"             => "required|string|max:255",
            "email"                => "required|email|unique:users,max:255",
            "password"             => "required|min:8|max:255",
            "passwordConfirmation" => "required|min:8|same:password|max:255",
        ];
    }
}
