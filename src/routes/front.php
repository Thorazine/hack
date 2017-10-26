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

	// Return the sitemap
	Route::get('sitemap.xml', function() {
		return response(Storage::disk(config('filesystems.default'))->get('sitemaps/'.Hack::siteId().'/sitemap.xml'), 200)
			->header('Content-Type', 'text/xml');
	});

	// Test database connection (ping service)
	Route::get('polling/database', function() {
		try {
		    DB::connection()->getPdo();
		} catch (\Exception $e) {
			return response("Could not connect to the database. Please check your configuration.", 500);
		}
	});

	// A post route for the form builder
	Route::post('/form-builder/store', ['as' => 'form-builder.store', 'uses' => 'FormBuilderController@store']);

	/**
	 * Uncomment this group if you want a country code prefix
	 * The middleware will redirect the browser to the browser
	 * language if nothing is given, but only if it matches a
	 * language in the dataset. If not it goes to the default
	 */
	// Route::group(['middleware' => 'language'], function() {

		// This needs to be the last route, it catches all
		Route::get('{slug}', ['as' => 'page', 'uses' => 'SlugController@slug'])->where('slug', '.*');

	// });
});
