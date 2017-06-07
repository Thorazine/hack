<?php

/*
|--------------------------------------------------------------------------
| Cms Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/**
 * Every protected route
 */
Route::group(['middleware' => 'sentinel.auth', 'namespace' => 'App\Http\Controllers\Cms'], function() {

	

});

