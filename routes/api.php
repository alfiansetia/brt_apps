<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CbmController;
use App\Http\Controllers\Api\ComponentController;
use App\Http\Controllers\Api\HmkmController;
use App\Http\Controllers\Api\LogbookController;
use App\Http\Controllers\Api\OilCoolantController;
use App\Http\Controllers\Api\OnboardingController;
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
    Route::apiResource('pools', PoolController::class)->names('api.pools');

    Route::get('unit-findcode/{unit:code}', [UnitController::class, 'findcode'])->name('api.units.findcode');
    Route::get('unit-paginate', [UnitController::class, 'paginate'])->name('api.units.paginate');
    Route::apiResource('units', UnitController::class)->names('api.units');

    Route::get('product-paginate', [ProductController::class, 'paginate'])->name('api.products.paginate');
    Route::apiResource('products', ProductController::class)->names('api.products');

    Route::get('component-paginate', [ComponentController::class, 'paginate'])->name('api.components.paginate');
    Route::apiResource('components', ComponentController::class)->names('api.components');

    Route::get('hmkm-paginate', [HmkmController::class, 'paginate'])->name('api.hmkms.paginate');
    Route::apiResource('hmkms', HmkmController::class)->names('api.hmkms');

    Route::get('oil-paginate', [OilCoolantController::class, 'paginate'])->name('api.oils.paginate');
    Route::apiResource('oils', OilCoolantController::class)->names('api.oils');

    Route::get('logbook-paginate', [LogbookController::class, 'paginate'])->name('api.logbooks.paginate');
    Route::apiResource('logbooks', LogbookController::class)->names('api.logbooks');

    Route::get('cbm-paginate', [CbmController::class, 'paginate'])->name('api.cbms.paginate');
    Route::apiResource('cbms', CbmController::class)->names('api.cbms');

    Route::get('user-paginate', [UserController::class, 'paginate'])->name('api.users.paginate');
    Route::apiResource('users', UserController::class)->names('api.users');

    Route::get('onboardings', [OnboardingController::class, 'index'])->name('api.onboardings.index');

    Route::group(['middleware' => ['role:admin']], function () {
    });
});
