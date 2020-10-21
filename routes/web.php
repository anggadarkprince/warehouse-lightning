<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
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

    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
        'document-types' => DocumentTypeController::class,
    ]);
});
