<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CbmController;
use App\Http\Controllers\CbmProjectController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\DmcrController;
use App\Http\Controllers\HmkmController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeluhanController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\OilCoolantController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\OneScaniaController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\PoolController;
use App\Http\Controllers\PpmController;
use App\Http\Controllers\PpmDataController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SpeedController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('onboarding.index');
});

Auth::routes([
    'register'  => false,
    'verify'    => false,
    'reset'     => false,
]);


Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding.index');
    Route::get('/onboarding/menu', [OnboardingController::class, 'menu'])->name('onboarding.menu');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile', [ProfileController::class, 'password'])->name('password.update');

    Route::get('logout', [LoginController::class, 'logout']);


    // Route::group(['middleware' => ['role:admin']], function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('units', [UnitController::class, 'index'])->name('units.index');
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('components', [ComponentController::class, 'index'])->name('components.index');
    Route::get('pools', [PoolController::class, 'index'])->name('pools.index');

    Route::get('hmkms', [HmkmController::class, 'index'])->name('hmkms.index');

    Route::get('oils', [OilCoolantController::class, 'index'])->name('oils.index');

    Route::get('logbooks', [LogbookController::class, 'index'])->name('logbooks.index');

    Route::get('cbms', [CbmController::class, 'index'])->name('cbms.index');

    Route::get('dmcrs', [DmcrController::class, 'index'])->name('dmcrs.index');

    Route::get('keluhans', [KeluhanController::class, 'index'])->name('keluhans.index');

    Route::get('ppms', [PpmController::class, 'index'])->name('ppms.index');
    Route::get('ppms', [PpmController::class, 'index'])->name('ppms.index');

    Route::get('ppms_data', [PpmDataController::class, 'index'])->name('ppms_data.index');

    Route::get('speeds', [SpeedController::class, 'index'])->name('speeds.index');

    Route::get('cbm_projects', [CbmProjectController::class, 'index'])->name('cbm_projects.index');

    Route::get('service/{service}/download', [ServiceController::class, 'download'])->name('services.download');
    Route::get('services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('service/{service}', [ServiceController::class, 'show'])->name('services.show');

    // });
    Route::get('/tes', [OnboardingController::class, 'tes'])->name('onboarding.tes');

    Route::get('one_scanias', [OneScaniaController::class, 'index'])->name('one_scanias.index');

    Route::get('data-part', [PartController::class, 'index'])->name('parts.index');
});
