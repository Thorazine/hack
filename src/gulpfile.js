// process.env.DISABLE_NOTIFIER = true;

const elixir    = require('laravel-elixir');
var gulp        = require('gulp');
                  require('laravel-elixir-livereload');
// require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {

    // cms
    mix.sass([
    	'cms.scss'
    ], 'public/assets/cms/css/cms.css')

    // frontend
    .sass([
        'frontend.scss'
    ], 'public/assets/frontend/css/frontend.css').livereload();



    // cms
    mix.scripts([
        '../../../node_modules/jquery/dist/jquery.min.js',
        '../../../node_modules/jqueryui/jquery-ui.min.js',
        '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        '../../../node_modules/moment/min/moment.min.js',
        '../../../node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
        '../../../node_modules/q/q.js',
        '../../../node_modules/cropper/dist/cropper.min.js',
        '../../../node_modules/dropzone/dist/min/dropzone.min.js',
        '../../../node_modules/nestedSortable/jquery.mjs.nestedSortable.js',
        'gateway.js',
        'model.js',
        'menu.js',
        'input/multi-checkbox.js',
        'input/aspect-ratio.js',
        'input/labeled-multi-checkbox.js',
        'input/gallery.js',
        'input/cropper.js',
        'input/image.js',
        'cms.js',
    ], 'public/assets/cms/js/cms.js')

    // auth
    .scripts([
        '../../../node_modules/jquery/dist/jquery.min.js',
        '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        'auth.js',
    ], 'public/assets/cms/js/auth.js')

    // frontend
    .scripts([
        '../../../node_modules/jquery/dist/jquery.min.js',
    ], 'public/assets/frontend/js/frontend.js')

    .livereload();
    // mix.browserSync({
    //     proxy: 'localhost/hack/public/'
    // });

});
