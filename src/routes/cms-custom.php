<?php

/**
 * Every protected route
 */
Route::group(['middleware' => 'sentinel.auth', 'namespace' => 'App\Http\Controllers\Cms'], function() {

	/*
	|----------------------------------------------------------------------
	| Example module route
	|----------------------------------------------------------------------
	|
	| Route::resource('module', 'ModuleController');
	|
	*/

	Route::get('panel', ['as' => 'panel.index', 'uses' => 'PanelController@index']);

});

