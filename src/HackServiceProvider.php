<?php

namespace Thorazine\Hack;

// use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class HackServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {

        $this->publishConfig();

        // $this->loadViewsFrom(__DIR__.'/resources/views', 'hack'); // add with the namespace "cms"

        $this->publishes([
            __DIR__.'/resources/views/cms' => resource_path('views/cms'),
            __DIR__.'/resources/views/1' => resource_path('views/1'),
            __DIR__.'/resources/views/offline.blade.php' => resource_path('views/offline.blade.php'),
        ], 'hack');

        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'cms');

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->registerClasses();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }


    private function registerClasses()
    {
        $classes = [
            // 'Http\Controllers\Cms\BuilderController',
            // 'Http\Controllers\Cms\CmsController',
            // 'Http\Controllers\Cms\CmsRoleController',
            // 'Http\Controllers\Cms\CmsUserController',
            // 'Http\Controllers\Cms\FormController',
            // 'Http\Controllers\Cms\FormFieldController',
            // 'Http\Controllers\Cms\FormValidationController',
            // 'Http\Controllers\Cms\MenuController',
            // 'Http\Controllers\Cms\MenuItemController',
            // 'Http\Controllers\Cms\NotFoundController',
            // 'Http\Controllers\Cms\PageController',
            // 'Http\Controllers\Cms\PanelController',
            // 'Http\Controllers\Cms\SiteController',
            // 'Http\Controllers\Cms\SlugController',
            // 'Http\Controllers\Cms\TemplateController',
            // 'Http\Controllers\Cms\Api\GalleryController',
            // 'Http\Controllers\Cms\Auth\AuthController',
            // 'Http\Controllers\Cms\Base\FirstController',
            // 'Http\Controllers\Cms\Email\ValidateController',
            // 'Http\Controllers\Front\SlugController',
            // 'Http\Controllers\Auth\ForgotPasswordController',
            // 'Http\Controllers\Auth\LoginController',
            // 'Http\Controllers\Auth\RegisterController',
            // 'Http\Controllers\Auth\ResetPasswordController',

            // 'Traits\ModuleHelper',
            // 'Traits\ModuleSearch',

            // 'Scopes\SiteScope',

            // 'Models\Form',
            // 'Models\FormEntry',
            // 'Models\FormField',
            // 'Models\FormValidation',
            // 'Models\FormValue',
            // 'Models\Gallery',
            // 'Models\CmsModel',
            // 'Models\Menu',
            // 'Models\MenuItem',
            // 'Models\NotFound',
            // 'Models\Page',
            // 'Models\Pageable',
            // 'Models\Site',
            // 'Models\Slug',
            // 'Models\Template',
            // 'Models\Templateable',
            // 'Models\Auth\CmsPersistence',
            // 'Models\Auth\CmsRole',
            // 'Models\Auth\CmsUser',
            // 'Models\Builders\BaseBuilder',
            // 'Models\Builders\Form',
            // 'Models\Builders\Image',
            // 'Models\Builders\Menu',
            // 'Models\Builders\Text',
            // 'Models\Builders\Textarea',
            // 'Models\Builders\Wysiwyg',


            // 'Http\Controllers\Cms\Controller',
        ];

        foreach($classes as $class) {
            $this->app->make('Thorazine\\Hack\\'.$class);
        }
    }


    private function publishConfig()
    {
        $this->publishes([
            __DIR__.'/config/cms.php' => config_path('cms.php'),
            __DIR__.'/config/cartalyst.sentinel.php' => config_path('cartalyst.sentinel.php'),
            __DIR__.'/config/image.php' => config_path('image.php'),
            __DIR__.'/config/languages.php' => config_path('languages.php'),
            __DIR__.'/config/menu.php' => config_path('menu.php'),
            __DIR__.'/config/rights.php' => config_path('rights.php'),
            __DIR__.'/package.json' => base_path('package.json'),
            __DIR__.'/gulpfile.js' => base_path('gulpfile.js'),
            __DIR__.'/resources/assets/fonts' => public_path('fonts'),
            __DIR__.'/resources/assets/images' => public_path('images'),
            __DIR__.'/resources/assets/js' => base_path('resources/assets/js'),
            __DIR__.'/resources/assets/sass' => base_path('resources/assets/sass'),
            __DIR__.'/resources/lang' => base_path('resources/lang'),
        ], 'hack');
    }
}
