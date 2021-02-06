<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingContainerController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\BookingGoodsController;
use App\Http\Controllers\Api\BookingTypeController;
use App\Http\Controllers\Api\ContainerController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DocumentTypeController;
use App\Http\Controllers\Api\GoodsController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\UploadDocumentController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('api.')->group(function () {

    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('token', [AuthController::class, 'token'])->name('auth.token');

    Route::middleware('auth:api')->group(function () {
        Route::get('user', [AuthController::class, 'user']);

        Route::prefix('user-access')->group(function() {
            Route::apiResources([
                'roles' => RoleController::class,
                'users' => UserController::class,
            ]);
        });
        Route::prefix('master')->group(function() {
            Route::apiResources([
                'document-types' => DocumentTypeController::class,
                'booking-types' => BookingTypeController::class,
                'customers' => CustomerController::class,
                'containers' => ContainerController::class,
            ]);
            Route::apiResource('goods', GoodsController::class, ['parameters' => ['goods' => 'goods']]);
        });

        Route::post('uploads/file', [UploadController::class, 'upload'])->name('uploads.file');
        Route::post('uploads/{upload}/validate', [UploadController::class, 'validateUpload'])->name('uploads.validate');
        Route::apiResource('uploads', UploadController::class);
        Route::apiResource('uploads.documents', UploadDocumentController::class)->only(['show', 'destroy']);

        Route::post('bookings/{booking}/validate', [BookingController::class, 'validateBooking'])->name('bookings.validate');
        Route::apiResource('bookings', BookingController::class);

        Route::get('bookings/{booking}/containers', [BookingContainerController::class, 'index'])->name('bookings.containers.index');
        Route::get('bookings/{booking}/goods', [BookingGoodsController::class, 'index'])->name('bookings.goods.index');
    });

});

