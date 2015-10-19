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

// Static routes
Route::get('/', 'SplashController@home');
Route::post('/email', 'SplashController@email');
Route::get('/thanks', 'SplashController@thanks');
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

// Resource routes
Route::group(['middleware' => 'auth', 'prefix' => 'dashboard'], function() {
    Route::get('/', ['as' => 'dashboard', function() {
      return view('dashboard');
    }]);

    Route::resource('clients', 'ClientsController');
      Route::resource('clients.invoices', 'ClientInvoicesController', ['except' => ['index']]);

    Route::resource('invoices', 'InvoicesController', ['only' => ['index']]);
    Route::resource('templates', 'TemplatesController');
    Route::resource('settings', 'UserSettingsController', ['only' => ['index', 'update']]);
});

// API Routes
Route::group(['prefix' => 'api/v1'], function() {
  Route::group(['middleware' => 'auth'], function() {
    Route::resource('clients.templates', 'Api\V2\ClientTemplatesController', ['only' => ['show']]);
    Route::resource('settings', 'Api\V2\UserSettingsController', ['only' => ['update']]);
  });
});


if (getenv('APP_ENV') == 'local') {
    Route::post('/email/{id}', 'AdminController@debugEmail');
}
