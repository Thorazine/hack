<?php

namespace Thorazine\Hack\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Thorazine\Hack\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapCmsRoutes();

        $this->mapFrontRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapCmsRoutes()
    {
        Route::group([
            'middleware' => ['web', 'site'],
            'namespace' => $this->namespace.'\Cms',
            'prefix' => 'cms',
            'as' => 'cms.'
        ], function ($router) {
            require __DIR__.'/../routes/cms.php';
        });
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapFrontRoutes()
    {
        Route::group([
            'middleware' => ['web', 'site'],
            'namespace' => $this->namespace,
        ], function ($router) {
            require __DIR__.'/../routes/front.php';
        });
    }
}
