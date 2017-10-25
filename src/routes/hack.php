<?php

Route::get('first', 'FirstController@index')->name('first.index');
Route::get('login', 'AuthController@index')->name('auth.index');


Route::group(['middleware' => 'sentinel.auth'], function() {

	Route::post('logout', 'AuthController@index')->name('auth.logout');

	Route::get('overview', 'OverviewController@index')->name('overview.index');

});
