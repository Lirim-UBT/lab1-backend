<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function(Request $request){
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function(){
    Route::post('/register', 'register');
});

Route::controller(AuthController::class)->group(function(){
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/refresh-token', 'refresh');
    Route::post('/logout', 'logout');
});

Route::controller(UserController::class)->group(function(){
    Route::get('/', 'getAll');
    Route::get('/{id}', 'getById');
    Route::get("professors", "getProfessors");
    Route::get("students", "getStudents");
    Route::get("admins", "getAdmins");
});
