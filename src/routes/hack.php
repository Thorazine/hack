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
	Route::get('settings', 'SettingsController@index')->name('settings.index');

	Route::get('subitem1', 'OverviewController@index')->name('subitem1.index');
	Route::get('subitem2', 'OverviewController@index')->name('subitem2.index');
	Route::get('subitem3', 'OverviewController@index')->name('subitem3.index');
	Route::get('subitem4', 'OverviewController@index')->name('subitem4.index');

});


Route::get('status.json', function() {
	return response()->json([
		[
			'version' => '2.0.0',
			'timestamp' => time(),
			'items' => [
				[
					'type' => 'code',
					'description' => 'Some long ass description of the update',
				],
				[
					'type' => 'style',
					'description' => 'Some long ass description of the update',
				],
				[
					'type' => 'security',
					'description' => 'Some long ass description of the update',
				],
			],
		],
	], 200);
});
