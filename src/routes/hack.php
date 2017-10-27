<?php

Route::group(['middleware' => 'sentinel.auth.not'], function() {
	Route::get('first', 'FirstController@index')->name('first.index');
	Route::get('login', 'AuthController@index')->name('auth.index');
	Route::get('/', 'AuthController@index')->name('auth.index.redirect');
});

Route::group(['middleware' => 'sentinel.auth'], function() {

	Route::get('login/persistence', 'AuthController@persistence')->name('auth.persistence');
	Route::get('login/persistence/validate', ['as' => 'auth.validate', 'uses' => 'AuthController@validatePersistence']);


	Route::post('logout', 'AuthController@index')->name('auth.logout');
	Route::get('overview', 'OverviewController@index')->name('overview.index');

});

