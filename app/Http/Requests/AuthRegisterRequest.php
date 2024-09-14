<?php

namespace App\Http\Requests;

class AuthRegisterRequest extends BaseRequest{
    public function rules(): array{
        return [
            "email"                => "required|email|unique:users,max:255",
            "password"             => "required|min:8",
            "passwordConfirmation" => "required|min:8|same:password",
        ];
    }
}
