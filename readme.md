## Introduction
This is a personal content management system I use for clients.
Feel free to try it, but don't expect support any day soon. 


## Included in package

- Multi site
- Multi domain
- Multi language front end
- Multi language CMS (language files can be added)
- 2 factor authentication based on known previous locations with custom radius
- Fully customisable rights authentication system (Sentinel)
- Persistant login with session control
- Advanced/automatic browser cache
- Full cache (memcached/redis) on front end requests 
- Cache flushed by tags, minimizing flushed items 
- Gallery with aspect ratio cropper (customisable per input)
- Customisable wysiwygs per input
- Easy to extend with your own modules
- Installable in excisting project
- Front end SASS tools
- Automatic response as JSON for API calls
- Uses Laravel filesystem, so CDN and local support
- Form builder/handler module
- Form data download as xls, xlsx or csv


## Requirements

- SSL (on every server that is not localhost)
- Mail capabilities (env settings)
- Npm
- Laravel 5.4.14 or higher install, preferably a clean install


## Installing Hack

Run
```
composer require thorazine/hack
```

# Add to config/app.providers:

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
        Maatwebsite\Excel\ExcelServiceProvider::class,
        Thorazine\Hack\Providers\RouteServiceProvider::class,
        Noprotocol\LaravelLocation\LocationServiceProvider::class,

# Add to config/app.aliases:

        'Form' => Collective\Html\FormFacade::class,
        'Html' => Collective\Html\HtmlFacade::class,
        'Debugbar' => Barryvdh\Debugbar\Facade::class,
        'Image' => Intervention\Image\Facades\Image::class,
        'Activation' => Cartalyst\Sentinel\Laravel\Facades\Activation::class,
        'Reminder' => Cartalyst\Sentinel\Laravel\Facades\Reminder::class,
        'Sentinel' => Cartalyst\Sentinel\Laravel\Facades\Sentinel::class,
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
        'Builder' => Thorazine\Hack\Facades\BuilderFacade::class,
        'Cms' => Thorazine\Hack\Facades\CmsFacade::class,
        'Front' => Thorazine\Hack\Facades\FrontFacade::class,
        'Location' => Noprotocol\LaravelLocation\Facades\LocationFacade::class,

# Add to the App\Http\Kernel $routeMiddleware:

        'sentinel.auth' => \Thorazine\Hack\Http\Middleware\SentinelAuthentication::class,
        'site' => \Thorazine\Hack\Http\Middleware\SiteRedirect::class,

# Add to resources\lang\en\validation.php
```php
    'slug'                 => 'Not a valid slug (a-z, 0-9, \'_\', and \'-\' are allowed',
```


Run
```
php artisan vendor:publish --tag=hack --force
php artisan vendor:publish --tag=location
php artisan migrate
npm install
gulp
```

# Filesystem
This package uses the default Laravel Filesystem to handle storage. For settings take a look at the [Laravel docs](https://laravel.com/docs/5.4/filesystem).
Personally I like to start of with the public driver and the ```php artisan storage:link``` command. 
Obviously you are going to want to have the url availible on whatever driver you use.

# Important
We use tags to control the cache. So set .env CACHE_DRIVER to array, memcached or redis. File will not do.

Make sure you have a mail driver setup. If you don't have that option just use "log" although I recommend [Mailhog](https://github.com/mailhog/MailHog). But be sure to make it functional on the production server as we send out mails to confirm the location if needed.

Now visit http://[domain]/cms and fill in the blancs.