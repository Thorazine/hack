<?php

// Localization
Route::get('/js/lang.js', function () {
    // $strings = Cache::rememberForever('lang.js', function () {
        $lang = config('app.locale');

        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

    //     return $strings;
    // });

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');


// Localization
Route::get('{language}/{file}-lang.js', function ($language, $file) {

	App::setLocale($language);

	$data = [
		$file => trans('hack::'.$file),
	];

	header('Content-Type: text/javascript');
	echo('window.i18n = ' . json_encode($data).';');
    exit();
})->name('assets.lang');
