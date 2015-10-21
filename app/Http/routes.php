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
      $pastDueInvoices = App\Invoice::with('client')->pastDue()->get();
      return view('dashboard', compact('pastDueInvoices'));
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
    Route::resource('clients.templates', 'Api\V1\ClientTemplatesController', ['only' => ['show']]);
    Route::resource('settings', 'Api\V1\UserSettingsController', ['only' => ['update']]);
    Route::resource('templates', 'Api\V1\TemplatesController', ['only' => ['store']]);
    Route::resource('invoices', 'Api\V1\InvoicesController', ['only' => ['show']]);
  });
});


if (getenv('APP_ENV') == 'local') {
    Route::post('/email/{id}', 'AdminController@debugEmail');
    Route::get('/pdf', function() {

      $invoice = \App\Invoice::with('lineItems', 'client')->where('published', true)->first();
      $client = $invoice->client;
      $template = \App\Template::find($invoice->template_id);

      // Save html to tmp file
      $generator = new App\Lib\PdfGenerator($template);
      $generator->makeHtml($client, $invoice, $invoice->total);
      $generator->generate();

      header("Content-type: application/pdf");
      header("Content-disposition: inline;filename='invoice.pdf'");

      return readfile($generator->pdfPath());
    });
}
