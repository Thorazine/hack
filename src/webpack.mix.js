let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
	// cms
	.sass('resources/assets/sass/cms.scss', 'public/assets/cms/css/cms.css')

    // frontend
    .sass('resources/assets/sass/frontend.scss', 'public/assets/frontend/css/frontend.css')

    // wysiwyg
    .sass('resources/assets/sass/wysiwyg.scss', 'public/assets/cms/css/wysiwyg.css')

    .scripts([

        'resources/assets/js/gateway.js',
        'resources/assets/js/model.js',
        'resources/assets/js/menu.js',
        'resources/assets/js/input/multi-checkbox.js',
        'resources/assets/js/input/aspect-ratio.js',
        'resources/assets/js/input/labeled-multi-checkbox.js',
        'resources/assets/js/input/gallery.js',
        'resources/assets/js/input/cropper.js',
        'resources/assets/js/input/image.js',
        'resources/assets/js/cms.js',
    ], 'public/assets/cms/js/cms.js')

    // auth
    .scripts([
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        'resources/assets/js/auth.js',
    ], 'public/assets/cms/js/auth.js');