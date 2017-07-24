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
- The default Laravel Auth is totally unused and therfore availible for your project
- Persistant login with session control
- Advanced/automatic browser cache
- Full cache (memcached/redis) on front end requests 
- Cache flushed by tags, minimizing flushed items 
- All pages and sites are equipped with editable on-/offline timestamps
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


## Add to config/app.providers:

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
        Thorazine\Location\LocationServiceProvider::class,


## Add to config/app.aliases:

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
        'Location' => Thorazine\Location\Facades\LocationFacade::class,


## Add to the App\Http\Kernel $routeMiddleware:

        'sentinel.auth' => \Thorazine\Hack\Http\Middleware\SentinelAuthentication::class,
        'site' => \Thorazine\Hack\Http\Middleware\SiteRedirect::class,


## Asset and database deployment
Run (although you might want to look at your migration folder first)
```
php artisan vendor:publish --tag=hack --force
php artisan migrate
npm install
npm run dev
```


## Database
The default setting for strictness of the database is set to true. This needs to be false for the system to work since we 
use the eloquent ```groupBy```.


## Filesystem
This package uses the default Laravel Filesystem to handle storage. For settings take a look at the [Laravel docs](https://laravel.com/docs/5.4/filesystem).
Personally I like to start of with the ```public``` driver setting and the ```php artisan storage:link``` command. To do so add ```FILESYSTEM_DRIVER=public``` to the .env file.
Obviously you are going to want to have the url availible on whatever driver you use.


## Cache
We use tags to control the cache. So set .env CACHE_DRIVER to array, memcached or redis. ```file``` will not do.
To set the cache time for the pages you can add ```PAGE_CACHE_TIME=[minutes]```. The default has been set to 1 minute cache.


## Important
Make sure you have a mail driver setup. If you don't have that option just use "log" although I recommend [Mailhog](https://github.com/mailhog/MailHog). But be sure to make it functional on the production server as we send out mails to confirm the location if needed.

Make sure your .env file is in order, especially the APP_URL. This is used by the filesystem.

Also, to properly work with locations we use the google api. You are going to want to get a key at [Google](https://developers.google.com/maps/documentation/javascript/get-api-key). Once you have an api key add ```GOOGLE_KEY=[key]``` to your .env file.

Now visit http://[domain]/cms and fill in the blancs.


## Example website
To get started you can seed the database with a simple Hack website. The seeder can be run by executing
```
php artisan db:seed --class=Thorazine\\Hack\\Database\\Seeds\\HackExampleSite
```
