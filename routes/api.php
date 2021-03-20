<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingContainerController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\BookingGoodsController;
use App\Http\Controllers\Api\BookingTypeController;
use App\Http\Controllers\Api\ContainerController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DeliveryOrderController;
use App\Http\Controllers\Api\DocumentTypeController;
use App\Http\Controllers\Api\GoodsController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\TakeStockController;
use App\Http\Controllers\Api\TallyController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\UploadDocumentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GateController;
use App\Http\Controllers\Api\WorkOrderController;
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

    Route::get('version', [ApiController::class, 'version'])->name('version');
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

        Route::apiResource('delivery-orders', DeliveryOrderController::class);

        Route::prefix('warehouse')->group(function() {
            Route::get('gate', [GateController::class, 'index'])->name('gate.index');
            Route::apiResource('work-orders', WorkOrderController::class);
            Route::get('tally', [TallyController::class, 'index'])->name('tally.index');
            Route::match(['post', 'put'], 'tally/{work_order}/take', [TallyController::class, 'takeJob'])->name('tally.take-job');
            Route::get('tally/{work_order}', [TallyController::class, 'proceedJob'])->name('tally.proceed-job');
            Route::match(['post', 'put'], 'tally/{work_order}/release', [TallyController::class, 'releaseJob'])->name('tally.release-job');
            Route::put('tally/{work_order}', [TallyController::class, 'saveJob'])->name('tally.save-job');
            Route::match(['post', 'put'], 'tally/{work_order}/complete', [TallyController::class, 'completeJob'])->name('tally.complete-job');
            Route::match(['post', 'put'], 'tally/{work_order}/validate', [TallyController::class, 'validateJob'])->name('tally.validate-job');
            Route::match(['post', 'put'], 'tally/{work_order}/reject', [TallyController::class, 'rejectJob'])->name('tally.reject-job');

            Route::post('take-stocks/{take_stock}/validate', [TakeStockController::class, 'validateTakeStock'])->name('take-stocks.validate');
            Route::post('take-stocks/{take_stock}/reject', [TakeStockController::class, 'rejectTakeStock'])->name('take-stocks.reject');
            Route::post('take-stocks/{take_stock}/submit', [TakeStockController::class, 'submit'])->name('take-stocks.submit');
            Route::apiResource('take-stocks', TakeStockController::class);
        });

        Route::get('reports/inbound', [ReportController::class, 'inbound'])->name('reports.inbound');
        Route::get('reports/outbound', [ReportController::class, 'outbound'])->name('reports.outbound');
        Route::get('reports/stock-summary', [ReportController::class, 'stockSummary'])->name('reports.stock-summary');
        Route::get('reports/stock-movement', [ReportController::class, 'stockMovement'])->name('reports.stock-movement');

        Route::get('search', [SearchController::class, 'index'])->name('search');
    });

});

