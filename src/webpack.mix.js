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

mix.js('vendor/thorazine/hack/src/resources/assets/js/auth.js', 'public/hack/js')
	.js('vendor/thorazine/hack/src/resources/assets/js/first.js', 'public/hack/js')
	.js('vendor/thorazine/hack/src/resources/assets/js/persistence.js', 'public/hack/js')

   .sass('vendor/thorazine/hack/src/resources/assets/sass/hack.scss', 'public/hack/css')
   .sass('vendor/thorazine/hack/src/resources/assets/sass/wysiwyg.scss', 'public/hack/css');


var LiveReloadPlugin = require('webpack-livereload-plugin');

mix.webpackConfig({
    plugins: [
        new LiveReloadPlugin()
    ]
});
