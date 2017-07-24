<?php

namespace Thorazine\Hack\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('slug', function ($attribute, $value, $parameters, $validator) {
            if($value == '') {
                return true;
            }
            return preg_match('/^[a-z0-9\-\/]+$/', $value);
        }, trans('hack::validation.slug'));
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
