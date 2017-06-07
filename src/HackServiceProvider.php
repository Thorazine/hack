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
            __DIR__.'/routes/cms.php' => base_path('routes/cms.php'),
            __DIR__.'/routes/cms-custom.php' => base_path('routes/cms-custom.php'),
            __DIR__.'/routes/front.php' => base_path('routes/front.php'),
        ], 'hack');

        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'cms');

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // Console commands
        if ($this->app->runningInConsole()) 
        {
            $this->commands([
                Console\Commands\HackBuilder::class,
                Console\Commands\HackModule::class,
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
