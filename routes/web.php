<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookingTypeController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UploadDocumentController;
use App\Http\Controllers\UploadDocumentFileController;
use App\Http\Controllers\UserController;
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
});

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

    Route::resource('uploads', UploadController::class);
    Route::get('uploads/{upload}/documents/{document}/download', [UploadDocumentController::class, 'download'])->name('uploads.documents.download');
    Route::resource('uploads.documents', UploadDocumentController::class)->except(['index', 'edit', 'update']);
    Route::get('uploads/{upload}/documents/{document}/files/{file}/download', [UploadDocumentFileController::class, 'download'])->name('uploads.documents.files.download');

});
