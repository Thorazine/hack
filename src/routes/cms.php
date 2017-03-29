<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('test', function() {

	$location = new \App\Classes\Tools\Location;

	// dd($location->coordinatesToAddress(52.3828617, 4.8907602)->get());
	// dd($location->addressToCoordinates(['country' => 'Netherlands', 'city' => 'Amsterdam', 'region' => ''])->get());
	// dd($location->ipToCoordinates('217.195.116.157')->get());
	// dd($location->ipToCoordinates('217.195.116.157')->coordinatesToAddress()->get());

});

/**
 * Basic
 */
Route::group(['namespace' => 'Base', 'prefix' => 'base', 'as' => 'base.'], function() {
	Route::get('first', ['as' => 'first', 'uses' => 'FirstController@index']);
	Route::post('first', ['as' => 'first.store', 'uses' => 'FirstController@store']);
	Route::get('first/success', ['as' => 'first.success', 'uses' => 'FirstController@success']);
});

/**
 * Authentication
 */
Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function() {
	Route::get('login', ['as' => 'index', 'uses' => 'AuthController@index']);
	Route::post('login', ['as' => 'store', 'uses' => 'AuthController@store']);
	Route::get('persistence', ['as' => 'persistence', 'uses' => 'AuthController@persistence', 'middleware' => 'sentinel.auth']);
	Route::get('persistence/resend', ['as' => 'persistence.resend', 'uses' => 'AuthController@resend', 'middleware' => 'sentinel.auth']);

	Route::group(['middleware' => 'sentinel.auth'], function() {
		Route::get('locked', ['as' => 'show', 'uses' => 'AuthController@show']);
		Route::get('logout', ['as' => 'destroy', 'uses' => 'AuthController@destroy']);
	});
});

/**
 * Emails incomming
 */
Route::group(['namespace' => 'Email', 'prefix' => 'email', 'as' => 'email.'], function() {
	Route::get('validate-persistence', ['as' => 'validate', 'uses' => 'ValidateController@validatePersistence']);
});

// redirect the simple url to the dashboard
Route::get('/', function() {
	return redirect()->route('cms.panel.index');
});

Route::group(['middleware' => 'sentinel.auth'], function() {

	Route::get('/panel', ['as' => 'panel.index', 'uses' => 'PanelController@index']);

	/**
	 * Module routing
	 */
	Route::resource('sites', 'SiteController');
	Route::resource('users', 'CmsUserController');
	Route::resource('roles', 'CmsRoleController');
	Route::resource('templates', 'TemplateController');
	Route::post('builder/order', ['as' => 'builder.order', 'uses' => 'BuilderController@order']);
	Route::resource('builder', 'BuilderController');
	Route::get('builder/module/create', ['as' => 'builder.module', 'uses' => 'BuilderController@module']);
	Route::resource('pages', 'PageController');
	Route::get('pages/module/create', ['as' => 'pages.module', 'uses' => 'PageController@module']);
	Route::resource('menus', 'MenuController');
	Route::post('menu_items/order', ['as' => 'menu_items.order', 'uses' => 'MenuItemController@order']);
	Route::resource('menu_items', 'MenuItemController');
	Route::resource('slugs', 'SlugController');
	Route::get('forms/download/{id}', ['as' => 'forms.download', 'uses' => 'FormController@download']);
	Route::resource('forms', 'FormController');
	Route::post('form_fields/order', ['as' => 'form_fields.order', 'uses' => 'FormFieldController@order']);
	Route::resource('form_fields', 'FormFieldController');
	Route::resource('form_entries', 'FormEntryController');
	Route::resource('form_validations', 'FormValidationController');
	Route::resource('gallery', 'GalleryController');
	Route::resource('not_found', 'NotFoundController');

	/**
	 * Gallery
	 */
	Route::group(['as' => 'api.', 'prefix' => 'api', 'namespace' => 'Api'], function() {
		Route::post('gallery/upload', ['as' => 'gallery.upload', 'uses' => 'GalleryController@upload']);
		Route::post('gallery/crop', ['as' => 'gallery.crop', 'uses' => 'GalleryController@crop']);
		Route::post('gallery/destroy', ['as' => 'gallery.destroy', 'uses' => 'GalleryController@delete']);
		Route::post('gallery.api', ['as' => 'gallery.api', 'uses' => 'GalleryController@api']);
	});
});

