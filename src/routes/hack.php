<?php

/**
 * Every protected route
 */
Route::group(['middleware' => 'sentinel.auth', 'namespace' => 'App\Http\Controllers\Cms'], function() {

	/*
	|----------------------------------------------------------------------
	| Example module route
	|----------------------------------------------------------------------
	| If you want to be able to order add this line first
	|----------------------------------------------------------------------
	| 
	| Route::post('example/order', ['as' => 'example.order', 'uses' => 'ExampleController@order']);
	|
	|----------------------------------------------------------------------
	| Always use the below line
	|----------------------------------------------------------------------
	| 
	| Route::resource('example', 'ExampleController');
	|
	|----------------------------------------------------------------------
	| More information here: https://github.com/Thorazine/hack/wiki/Adding-a-custom-module
	|----------------------------------------------------------------------
	*/

	Route::get('panel', ['as' => 'panel.index', 'uses' => 'PanelController@index']);

});

