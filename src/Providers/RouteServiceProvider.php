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
    protected $vendorNamespace = 'Thorazine\Hack\Http\Controllers';

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
        $this->mapHackRoutes();
        $this->mapHackApiRoutes();
        $this->mapHackLanguageRoutes();
        $this->mapFrontRoutes();
    }

    /**
     * Define the "web" routes for Hack.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapHackRoutes()
    {
        Route::group([
            'middleware' => ['web', 'site'],
            'namespace' => $this->vendorNamespace,
            'prefix' => 'hack',
            'as' => 'hack.'
        ], function ($router) {
            require base_path('vendor/thorazine/hack/src/routes/hack.php');
        });
    }

    /**
     * Define the "api" routes for Hack.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapHackApiRoutes()
    {
        Route::group([
            'middleware' => ['web', 'site'],
            'namespace' => $this->vendorNamespace.'\Api',
            'prefix' => 'hack/api',
            'as' => 'hack.api.'
        ], function ($router) {
            require base_path('vendor/thorazine/hack/src/routes/api.php');
        });
    }

    /**
     * Define the "language" routes for Hack.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapHackLanguageRoutes()
    {
        Route::group([
            'middleware' => [],
            'prefix' => 'hack/js',
            'as' => 'hack.language.'
        ], function ($router) {
            require base_path('vendor/thorazine/hack/src/routes/language.php');
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
        ], function ($router) {
            if(file_exists(base_path('routes/front.php'))) {
                require base_path('routes/front.php');
            }
        });
    }
}
