<?php

use Illuminate\Http\Request;
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

Route::name('api.')->namespace('App\Http\Controllers\Api')->group(function () {

    Route::post('login', 'AuthController@login')->name('auth.login');
    Route::post('register', 'AuthController@register')->name('auth.register');
    Route::post('token', 'AuthController@token')->name('auth.token');

    Route::middleware('auth:api')->group(function () {
        Route::get('user', 'AuthController@user');
    });

});

