<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\HmkmController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes([
    'register'  => false,
    'verify'    => false,
    'reset'     => false,
]);


Route::group(['middleware' => ['auth']], function () {
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding.index');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile', [ProfileController::class, 'password'])->name('password.update');


    // Route::group(['middleware' => ['role:admin']], function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('units', [UnitController::class, 'index'])->name('units.index');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('components', [ComponentController::class, 'index'])->name('components.index');
    Route::get('hmkms', [HmkmController::class, 'index'])->name('hmkms.index');
    // });
});
