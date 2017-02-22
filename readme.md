## Requirements

- SSL (on every server that is not localhost)
- Mail capabilities
- Npm
- Laravel 5.3 or higher install, preferably a clean install


## Installing Hack

Run
```
composer require thorazine/hack
```

#Add to config/app.providers:

	Collective\Html\HtmlServiceProvider::class,
    Barryvdh\Debugbar\ServiceProvider::class,
	App\Providers\HackServiceProvider::class,
    App\Providers\BuilderServiceProvider::class,
    App\Providers\CmsServiceProvider::class,
    App\Providers\FrontServiceProvider::class,
    App\Providers\ValidationServiceProvider::class,
    Intervention\Image\ImageServiceProvider::class,
    Cartalyst\Sentinel\Laravel\SentinelServiceProvider::class,
    Jenssegers\Agent\AgentServiceProvider::class,

#Add to config/app.aliases:

	'Form' => Collective\Html\FormFacade::class,
    'Html' => Collective\Html\HtmlFacade::class,
    'Debugbar' => Barryvdh\Debugbar\Facade::class,
    'Image' => Intervention\Image\Facades\Image::class,
    'Activation' => Cartalyst\Sentinel\Laravel\Facades\Activation::class,
    'Reminder'   => Cartalyst\Sentinel\Laravel\Facades\Reminder::class,
    'Sentinel'   => Cartalyst\Sentinel\Laravel\Facades\Sentinel::class,
    'Builder' => App\Facades\BuilderFacade::class,
    'Cms' => App\Facades\CmsFacade::class,
    'Front' => App\Facades\FrontFacade::class,

#Add to the App\Http\Kernel $routeMiddleware:

    'sentinel.auth' => \Thorazine\Hack\Http\Middleware\SentinelAuthentication::class,
    'site' => \Thorazine\Hack\Http\Middleware\SiteRedirect::class,


Run
```
php artisan vendor:publish --tag=hack --force
npm install
gulp
```

We use tags to control the cache. So set .env CACHE_DRIVER to array, memcached or redis. File will not do.

Make sure you have a mail driver setup. If you don't have that option just use "log". But be sure to make it functional on the production server as we send out mails to confirm the location if needed.