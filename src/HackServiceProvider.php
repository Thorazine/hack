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
        $this->publishes([
            // config
            __DIR__.'/config/cms.php' => config_path('cms.php'),
            __DIR__.'/config/cartalyst.sentinel.php' => config_path('cartalyst.sentinel.php'),
            __DIR__.'/config/image.php' => config_path('image.php'),
            __DIR__.'/config/languages.php' => config_path('languages.php'),
            __DIR__.'/config/menu.php' => config_path('menu.php'),
            __DIR__.'/config/rights.php' => config_path('rights.php'),

            // js and style
            __DIR__.'/package.json' => base_path('package.json'),
            __DIR__.'/webpack.mix.js' => base_path('webpack.mix.js'),
            __DIR__.'/resources/assets/theme' => public_path('theme'),
            __DIR__.'/resources/assets/fonts' => public_path('fonts'),
            __DIR__.'/resources/assets/images' => public_path('images'),
            __DIR__.'/resources/assets/js' => base_path('resources/assets/js'),
            __DIR__.'/resources/assets/sass' => base_path('resources/assets/sass'),

            // language files
            __DIR__.'/resources/lang/stubs/en/modules.php' => base_path('resources/lang/vendor/hack/en/modules.php'),
            __DIR__.'/resources/lang/stubs/nl/modules.php' => base_path('resources/lang/vendor/hack/nl/modules.php'),
            __DIR__.'/resources/lang/stubs/en/menu.php' => base_path('resources/lang/vendor/hack/en/menu.php'),
            __DIR__.'/resources/lang/stubs/nl/menu.php' => base_path('resources/lang/vendor/hack/nl/menu.php'),
            __DIR__.'/resources/lang/stubs/en/cms.php' => base_path('resources/lang/vendor/hack/en/cms.php'),
            __DIR__.'/resources/lang/stubs/nl/cms.php' => base_path('resources/lang/vendor/hack/nl/cms.php'),
            __DIR__.'/resources/lang/stubs/en/builder.php' => base_path('resources/lang/vendor/hack/en/builder.php'),
            __DIR__.'/resources/lang/stubs/nl/builder.php' => base_path('resources/lang/vendor/hack/nl/builder.php'),

            // views
            // __DIR__.'/resources/views/cms' => resource_path('views/cms'),
            __DIR__.'/resources/views/1' => resource_path('views/1'),
            __DIR__.'/resources/views/offline.blade.php' => resource_path('views/offline.blade.php'),

            // routes
            __DIR__.'/routes/front.php' => base_path('routes/front.php'),
            __DIR__.'/routes/hack.php' => base_path('routes/hack.php'),


            // stubs
            __DIR__.'/Http/Controllers/Cms/stubs/PanelController.stub' => app_path('Http/Controllers/Cms/PanelController.php'),
        ], 'hack');

        // Register the migrations
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views/cms', 'hack');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'hack');

        // Register console commands
        if($this->app->runningInConsole()) 
        {
            $this->commands([
                Console\Commands\HackBuilder::class,
                Console\Commands\HackModule::class,
                Console\Commands\HackSearch::class,
            ]);
        }

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // as of version 1.0.20
        $this->mergeConfigFrom(__DIR__.'/config/cms.php', 'cms.search.view_bind');
    }
}
