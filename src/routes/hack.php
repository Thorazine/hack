<?php

Route::get('first', 'FirstController@index')->name('first.index');
Route::get('login', 'AuthController@index')->name('auth.index');
Route::get('login/persistence/validate', ['as' => 'auth.validate', 'uses' => 'AuthController@validate']);

Route::group(['middleware' => 'sentinel.auth'], function() {

	Route::get('login/persistence', 'AuthController@persistence')->name('auth.persistence');


	Route::post('logout', 'AuthController@index')->name('auth.logout');
	Route::get('overview', 'OverviewController@index')->name('overview.index');

});
