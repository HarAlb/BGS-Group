<?php

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


Route::group(['middleware' => ['cors', 'json.response' , 'api']], function () {
    // Authentication
    Route::group(['namespace' => 'Auth'], function (){
        Route::post('register' , 'ApiAuthController@register')->name('register');
        Route::post('login' , 'ApiAuthController@login')->name('login');
        Route::get('user', 'ApiAuthController@user');
        Route::get('logout', 'ApiAuthController@logout');
    });

    Route::group(['namespace' => 'Event'], function () {
        Route::apiResource('event', 'EventController');
        Route::get('event/{event}/apply' , 'EventController@apply');
    });

});

