<?php

Route::post('first', 'FirstController@store')->name('first.store');
// auth routes
Route::post('authenticate', 'AuthController@authenticate')->name('auth.authenticate');


Route::group(['middleware' => 'sentinel.auth'], function() {


});
