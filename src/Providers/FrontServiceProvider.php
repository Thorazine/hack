<?php

namespace Thorazine\Hack\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class FrontServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('front', function()
        {
            return new \Thorazine\Hack\Classes\Facades\Front;
        });
    }
}
