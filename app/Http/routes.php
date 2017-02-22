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

Route::options('{all}', function () {
    return response('ok', 200)
        ->header('Access-Control-Allow-Credentials', 'true')
        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With')
        ->header('Access-Control-Allow-Origin', '*');
})->where('all', '.*');

Route::get('/', 'WelcomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


// Tag resources

Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {
	Route::group(['prefix' => 'hotspot'], function () {
		Route::post('search', 'HotspotController@search');
		Route::post('store', 'HotspotController@store');
		
	});
	
	Route::group(['prefix' => 'user'], function () {
		Route::get('{number}', 'UserController@show');	
	    Route::resource('/', 'UserController');
	});
});


