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

Route::get('/', 'SplashController@home');
Route::post('/email', 'SplashController@email');
Route::post('/contact', 'SplashController@contact');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Admin routes...
Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function() {
    Route::get('/', 'AdminController@index');
    Route::get('/contact/{id}', [
        'uses' => 'AdminController@respond',
        'as' => 'contact.respond'
    ]);
    Route::post('/contact/{id}', [
        'uses' => 'AdminController@send',
        'as' => 'contact.send'
    ]);
});


if (getenv('APP_ENV') == 'local') {
    Route::post('/email/{id}', 'AdminController@debugEmail');
}
