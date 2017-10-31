<?php

Route::post('first', 'FirstController@store')->name('first.store');
// auth routes
Route::post('authenticate', 'AuthController@authenticate')->name('auth.authenticate');


Route::group(['middleware' => 'sentinel.auth'], function() {

	Route::post('authenticate/validate/resend', 'AuthController@resend')->name('auth.validate.resend');

	Route::post('settings/cache', 'SettingController@cache')->name('settings.cache');
	Route::post('settings/search', 'SettingController@search')->name('settings.search');
	Route::post('settings/update', 'SettingController@update')->name('settings.update');

});
