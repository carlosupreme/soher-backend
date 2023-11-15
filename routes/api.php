<?php

use App\Http\Controllers\AuthApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthApiController::class, 'register']);
Route::post('login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', static fn() => Auth::user());
    Route::get('logout', [AuthApiController::class, 'logout']);
});
