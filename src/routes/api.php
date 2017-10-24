<?php

// auth routes
Route::post('authenticate', 'AuthController@authenticate')->name('auth.authenticate');


Route::group(['middleware' => 'sentinel.auth'], function() {


});
