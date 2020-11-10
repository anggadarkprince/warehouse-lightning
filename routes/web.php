<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookingContainerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingGoodsController;
use App\Http\Controllers\BookingTypeController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UploadDocumentController;
use App\Http\Controllers\UploadDocumentFileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/legals', function () {
    return view('legals.index');
})->name('legals.index');

Route::get('/privacy', function () {
    return view('legals.privacy');
})->name('legals.privacy');

Route::get('/agreement', function () {
    return view('legals.agreement');
})->name('legals.agreement');

Route::get('/cookie', function () {
    return view('legals.cookie');
})->name('legals.cookie');

Route::get('/sla', function () {
    return view('legals.sla');
})->name('legals.sla');


Route::middleware(['auth'])->group(function() {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('password.confirm')->group(function() {
        Route::get('account', [AccountController::class, 'index'])->name('account');
        Route::get('settings', [SettingController::class, 'index'])->name('settings');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });

    Route::prefix('user-access')->group(function() {
        Route::resources([
            'roles' => RoleController::class,
            'users' => UserController::class,
        ]);
    });

    Route::prefix('master')->group(function() {
        Route::resources([
            'document-types' => DocumentTypeController::class,
            'booking-types' => BookingTypeController::class,
            'customers' => CustomerController::class,
            'containers' => ContainerController::class,
        ]);
        Route::resource('goods', GoodsController::class, ['parameters' => ['goods' => 'goods']]);
    });

    Route::post('uploads/file', [UploadController::class, 'upload'])->name('uploads.file');
    Route::post('uploads/{upload}/validate', [UploadController::class, 'validateUpload'])->name('uploads.validate');
    Route::get('uploads/{upload}/download', [UploadController::class, 'download'])->name('uploads.download');
    Route::resource('uploads', UploadController::class);

    Route::get('uploads/{upload}/documents/{document}/download', [UploadDocumentController::class, 'download'])->name('uploads.documents.download');
    Route::resource('uploads.documents', UploadDocumentController::class)->only(['show', 'destroy']);

    Route::get('uploads/{upload}/documents/{document}/files/{file}/download', [UploadDocumentFileController::class, 'download'])->name('uploads.documents.files.download');
    Route::get('uploads/{upload}/documents/{document}/files/{file}/preview', [UploadDocumentFileController::class, 'preview'])->name('uploads.documents.files.preview');

    Route::get('bookings/import', [BookingController::class, 'import'])->name('bookings.import');
    Route::get('bookings/{booking}/xml', [BookingController::class, 'xml'])->name('bookings.xml');
    Route::match(['get', 'post'], 'bookings/import-preview', [BookingController::class, 'importPreview'])->name('bookings.xml-preview');
    Route::post('bookings/import', [BookingController::class, 'storeImport'])->name('bookings.store-import');
    Route::post('bookings/{booking}/validate', [BookingController::class, 'validateBooking'])->name('bookings.validate');
    Route::resource('bookings', BookingController::class);

    Route::get('bookings/{booking}/containers', [BookingContainerController::class, 'index'])->name('bookings.containers.index');
    Route::get('bookings/{booking}/goods', [BookingGoodsController::class, 'index'])->name('bookings.goods.index');

    Route::get('delivery-orders/{delivery_order}/print', [DeliveryOrderController::class, 'printDeliveryOrder'])->name('delivery-orders.print');
    Route::resource('delivery-orders', DeliveryOrderController::class);

    Route::get('gate', [GateController::class, 'index'])->name('gate.index');
    Route::get('work-orders/{work_order}/print', [WorkOrderController::class, 'printWorkOrder'])->name('work-orders.print');
    Route::resource('work-orders', WorkOrderController::class)->except('index');
});
