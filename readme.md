## Introduction
This is a personal content management system I use for clients.
Feel free to try it, but don't expect support. 


## Requirements

- SSL (on every server that is not localhost)
- Mail capabilities
- Npm
- Laravel 5.4.14 or higher install, preferably a clean install


## Installing Hack

Run
```
composer require thorazine/hack
```

#Add to config/app.providers:

    	Collective\Html\HtmlServiceProvider::class,
        Barryvdh\Debugbar\ServiceProvider::class,
    	Thorazine\Hack\HackServiceProvider::class,
        Thorazine\Hack\Providers\BuilderServiceProvider::class,
        Thorazine\Hack\Providers\CmsServiceProvider::class,
        Thorazine\Hack\Providers\FrontServiceProvider::class,
        Thorazine\Hack\Providers\ValidationServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        Cartalyst\Sentinel\Laravel\SentinelServiceProvider::class,
        Jenssegers\Agent\AgentServiceProvider::class,
        Thorazine\Hack\Providers\RouteServiceProvider::class,

#Add to config/app.aliases:

    	'Form' => Collective\Html\FormFacade::class,
        'Html' => Collective\Html\HtmlFacade::class,
        'Debugbar' => Barryvdh\Debugbar\Facade::class,
        'Image' => Intervention\Image\Facades\Image::class,
        'Activation' => Cartalyst\Sentinel\Laravel\Facades\Activation::class,
        'Reminder'   => Cartalyst\Sentinel\Laravel\Facades\Reminder::class,
        'Sentinel'   => Cartalyst\Sentinel\Laravel\Facades\Sentinel::class,
        'Builder' => Thorazine\Hack\Facades\BuilderFacade::class,
        'Cms' => Thorazine\Hack\Facades\CmsFacade::class,
        'Front' => Thorazine\Hack\Facades\FrontFacade::class,

#Add to the App\Http\Kernel $routeMiddleware:

        'sentinel.auth' => \Thorazine\Hack\Http\Middleware\SentinelAuthentication::class,
        'site' => \Thorazine\Hack\Http\Middleware\SiteRedirect::class,


Run
```
php artisan vendor:publish --tag=hack --force
php artisan migrate
npm install
gulp
```

I use tags to control the cache. So set .env CACHE_DRIVER to array, memcached or redis. File will not do.

Make sure you have a mail driver setup. If you don't have that option just use "log". But be sure to make it functional on the production server as I send out mails to confirm the location if needed.