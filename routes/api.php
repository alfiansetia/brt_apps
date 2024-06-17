<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ComponentController;
use App\Http\Controllers\Api\HmkmController;
use App\Http\Controllers\Api\PoolController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('api.login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('profile', [AuthController::class, 'profile'])->name('api.profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('api.profile.update');
    Route::put('/profile', [ProfileController::class, 'password'])->name('api.password.update');

    Route::get('pool-paginate', [PoolController::class, 'paginate'])->name('api.pools.paginate');
    Route::resource('pools', PoolController::class)->names('api.pools');

    Route::get('unit-findcode/{unit:code}', [UnitController::class, 'findcode'])->name('api.units.findcode');
    Route::get('unit-paginate', [UnitController::class, 'paginate'])->name('api.units.paginate');
    Route::resource('units', UnitController::class)->names('api.units');

    Route::get('category-paginate', [CategoryController::class, 'paginate'])->name('api.categories.paginate');
    Route::resource('categories', CategoryController::class)->names('api.categories');

    Route::get('product-paginate', [ProductController::class, 'paginate'])->name('api.products.paginate');
    Route::resource('products', ProductController::class)->names('api.products');

    Route::get('component-paginate', [ComponentController::class, 'paginate'])->name('api.components.paginate');
    Route::resource('components', ComponentController::class)->names('api.components');

    Route::get('hmkm-paginate', [HmkmController::class, 'paginate'])->name('api.hmkms.paginate');
    Route::resource('hmkms', HmkmController::class)->names('api.hmkms');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::apiResource('users', UserController::class)->names('api.users');
    });
});
