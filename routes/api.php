<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('api.login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('profile', [AuthController::class, 'profile'])->name('api.profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('api.profile.update');
    Route::put('/profile', [ProfileController::class, 'password'])->name('api.password.update');


    Route::group(['middleware' => ['role:admin']], function () {
        Route::apiResource('users', UserController::class)->names('api.users');
    });
});
