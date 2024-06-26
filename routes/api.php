<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CbmController;
use App\Http\Controllers\Api\ComponentController;
use App\Http\Controllers\Api\DmcrController;
use App\Http\Controllers\Api\HmkmController;
use App\Http\Controllers\Api\KeluhanController;
use App\Http\Controllers\Api\LogbookController;
use App\Http\Controllers\Api\OilCoolantController;
use App\Http\Controllers\Api\OnboardingController;
use App\Http\Controllers\Api\PoolController;
use App\Http\Controllers\Api\PpmController;
use App\Http\Controllers\Api\PpmDataController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SpeedController;
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

    Route::get('product-findcode/{product:code}', [ProductController::class, 'findcode'])->name('api.products.findcode');
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

    Route::get('dmcr-paginate', [DmcrController::class, 'paginate'])->name('api.dmcrs.paginate');
    Route::apiResource('dmcrs', DmcrController::class)->names('api.dmcrs');

    Route::get('keluhan-paginate', [KeluhanController::class, 'paginate'])->name('api.keluhans.paginate');
    Route::apiResource('keluhans', KeluhanController::class)->names('api.keluhans');

    Route::get('ppm-paginate', [PpmController::class, 'paginate'])->name('api.ppms.paginate');
    Route::apiResource('ppms', PpmController::class)->names('api.ppms');

    Route::get('ppmdata-paginate', [PpmDataController::class, 'paginate'])->name('api.ppmdatas.paginate');
    Route::apiResource('ppmdatas', PpmDataController::class)->names('api.ppmdatas');

    Route::get('speed-paginate', [SpeedController::class, 'paginate'])->name('api.speeds.paginate');
    Route::apiResource('speeds', SpeedController::class)->names('api.speeds');

    Route::get('user-paginate', [UserController::class, 'paginate'])->name('api.users.paginate');
    Route::apiResource('users', UserController::class)->names('api.users');

    Route::get('onboardings', [OnboardingController::class, 'index'])->name('api.onboardings.index');

    Route::group(['middleware' => ['role:admin']], function () {
    });
});
