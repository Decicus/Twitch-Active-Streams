<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function() {
    Route::get('/', ['as' => 'home', 'uses' => 'PageController@home']);

    Route::group(['prefix' => 'streams', 'as' => 'streams.'], function() {
        Route::get('/', ['as' => 'main', 'uses' => 'PageController@streams']);
        Route::get('/{user?}', ['as' => 'user', 'uses' => 'PageController@streams'])
            ->where('user', '([A-z0-9]{1,25})');
    });

    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('/twitch', ['as' => 'twitch', 'uses' => 'AuthController@redirectToProvider']);
        Route::get('/twitch/callback', ['as' => 'twitch.callback', 'uses' => 'AuthController@handleProviderCallback']);
        Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['admin']], function () {
        Route::get('/', ['as' => 'home', 'uses' => 'AdminController@home']);
        Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
            Route::get('add', ['as' => 'add', 'uses' => 'AdminController@addUser']);
            Route::post('add', ['uses' => 'AdminController@addUserPost']);
        });
    });
});
