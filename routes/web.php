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
use App\Http\Controllers\Landing\AgentController;
use App\Http\Controllers\Landing\FaqController;
use App\Http\Controllers\Landing\FindLocationController;
use App\Http\Controllers\Landing\LegalController;
use App\Http\Controllers\Landing\ConsumerController;
use App\Http\Controllers\Landing\TrackTraceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequestQuoteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TakeStockController;
use App\Http\Controllers\TallyController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UploadDocumentController;
use App\Http\Controllers\UploadDocumentFileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkOrderController;
use Illuminate\Support\Facades\Broadcast;
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
Broadcast::routes();

Route::middleware('frontend.maintenance')->group(function() {
    Route::get('/', function () {
        return view('landing.home');
    })->name('welcome');

    Route::get('request-quote', [RequestQuoteController::class, 'index'])->name('landing.request-quote');
    Route::get('track-trace', [TrackTraceController::class, 'index'])->name('landing.track-trace');
    Route::get('find-location', [FindLocationController::class, 'index'])->name('landing.find-location');
    Route::get('agent', [AgentController::class, 'index'])->name('landing.agent');
    Route::get('faq', [FaqController::class, 'index'])->name('landing.faq');

    Route::get('retail-consumer', [ConsumerController::class, 'retail'])->name('landing.retail-consumer');
    Route::get('science-healthcare', [ConsumerController::class, 'healthcare'])->name('landing.science-healthcare');
    Route::get('industrial-chemical', [ConsumerController::class, 'industrial'])->name('landing.industrial-chemical');
    Route::get('power-generation', [ConsumerController::class, 'power'])->name('landing.power-generation');
    Route::get('food-beverage', [ConsumerController::class, 'food'])->name('landing.food-beverage');
    Route::get('oil-gas', [ConsumerController::class, 'oil'])->name('landing.oil-gas');

    Route::prefix('/legals')->group(function() {
        Route::get('/{page}', [LegalController::class, 'index'])->name('landing.solution');
    });

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

    Route::get('/contact', function () {
        return view('landing.contact');
    })->name('landing.contact');

    Route::get('/features', function () {
        return view('landing.features');
    })->name('landing.features');

    Route::get('/use-case', function () {
        return view('landing.use-case');
    })->name('landing.use-case');

    Route::get('/solution', function () {
        return view('landing.solution');
    })->name('landing.solution');
});

// redefined for localization prefix
require base_path('vendor/laravel/fortify/routes/routes.php');

Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('login.google.callback');
Route::get('login/twitter', [LoginController::class, 'redirectToTwitter'])->name('login.twitter');
Route::get('login/twitter/callback', [LoginController::class, 'handleTwitterCallback'])->name('login.twitter.callback');
Route::get('login/facebook', [LoginController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [LoginController::class, 'handleFacebookCallback'])->name('login.facebook.callback');

Route::middleware(['auth'])->group(function() {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::get('notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');

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

    Route::prefix('warehouse')->group(function() {
        Route::get('gate', [GateController::class, 'index'])->name('gate.index');
        Route::get('work-orders/{work_order}/print', [WorkOrderController::class, 'printWorkOrder'])->name('work-orders.print');
        Route::resource('work-orders', WorkOrderController::class)->except('index');

        Route::get('tally', [TallyController::class, 'index'])->name('tally.index');
        Route::match(['post', 'put'], 'tally/{work_order}/take', [TallyController::class, 'takeJob'])->name('tally.take-job');
        Route::get('tally/{work_order}', [TallyController::class, 'proceedJob'])->name('tally.proceed-job');
        Route::match(['post', 'put'], 'tally/{work_order}/release', [TallyController::class, 'releaseJob'])->name('tally.release-job');
        Route::put('tally/{work_order}', [TallyController::class, 'saveJob'])->name('tally.save-job');
        Route::match(['post', 'put'], 'tally/{work_order}/complete', [TallyController::class, 'completeJob'])->name('tally.complete-job');
        Route::match(['post', 'put'], 'tally/{work_order}/validate', [TallyController::class, 'validateJob'])->name('tally.validate-job');

        Route::get('take-stocks/{take_stock}/print', [TakeStockController::class, 'printTakeStock'])->name('take-stocks.print');
        Route::post('take-stocks/{take_stock}/validate', [TakeStockController::class, 'validateTakeStock'])->name('take-stocks.validate');
        Route::post('take-stocks/{take_stock}/submit', [TakeStockController::class, 'submit'])->name('take-stocks.submit');
        Route::resource('take-stocks', TakeStockController::class);
    });

    Route::get('reports/inbound', [ReportController::class, 'inbound'])->name('reports.inbound');
    Route::get('reports/outbound', [ReportController::class, 'outbound'])->name('reports.outbound');
    Route::get('reports/stock-summary', [ReportController::class, 'stockSummary'])->name('reports.stock-summary');
    Route::get('reports/stock-movement', [ReportController::class, 'stockMovement'])->name('reports.stock-movement');

    Route::get('search', [SearchController::class, 'index'])->name('search');
});
