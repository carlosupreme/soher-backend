<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthApiController::class, 'register']);
Route::post('login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', static fn() => Auth::user());
    Route::get('logout', [AuthApiController::class, 'logout']);

    Route::resource('/work', WorkController::class)->except('create', 'edit', 'destroy')->names('work');
});
