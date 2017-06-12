<?php

/*
|--------------------------------------------------------------------------
| Predefined frontend routes
|--------------------------------------------------------------------------
|
| This area contains the routes Hack needs to work. Alteration is 
| not recommended.
|
*/
Route::group(['namespace' => 'Thorazine\Hack\Http\Controllers\Front'], function() {

	// A post route for the form builder
	Route::post('/form-builder/store', ['as' => 'form-builder.store', 'uses' => 'FormBuilderController@store']);

	// This needs to be the last route, it catches all
	Route::get('{slug}', ['as' => 'page', 'uses' => 'SlugController@slug'])->where('slug', '.*');
});