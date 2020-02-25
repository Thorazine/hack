<p align="center">
<a href="https://packagist.org/packages/thorazine/hack"><img src="https://poser.pugx.org/thorazine/hack/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/thorazine/hack"><img src="https://poser.pugx.org/thorazine/hack/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/thorazine/hack"><img src="https://poser.pugx.org/thorazine/hack/license.svg" alt="License"></a>
</p>

## Introduction
This is a personal content management system I use for clients.
Feel free to try it, but don't expect support any day soon.


## Included in package

- Multi site
- Multi domain
- Multi language frontend
- Multi language CMS (language files can be added)
- 2 factor authentication based on known previous locations with custom radius
- Fully customisable rights authentication system (Sentinel)
- The default Laravel Auth is totally unused and therfore availible for your project
- Persistant login with session control
- Advanced/automatic browser cache
- Full cache (memcached/redis) on frontend requests
- Cache flushed by tags, minimizing flushed items
- All pages and sites are equipped with editable on-/offline timestamps
- Gallery with aspect ratio cropper (customisable per input)
- Customisable wysiwygs per input and pre site
- Easy to extend with your own modules
- Installable in excisting project
- Frontend SASS tools
- Automatic response as JSON for API calls
- Uses Laravel filesystem, so CDN and local support
- Form builder/handler module
- Form data download as xls, xlsx or csv


## Requirements
- SSL (on every server that is not localhost)
- Mail capabilities
- Npm
- Laravel ^5.4 install, preferably a clean install


## Installing Hack
Take a Laravel project with a working database and a writable storage folder.

Run
```
composer require thorazine/hack
```


## Add to config/app.providers:

```php
Thorazine\Hack\HackServiceProvider::class,
```

## Run installation
Run:
```
php artisan hack:install --force
npm install
npm run dev
```

This command runs some commands and finds and replaces some settings. What it exactly does can be found on the
[wiki page](https://github.com/Thorazine/hack/wiki/Manual-installation-and-setup).


## Settings
Now that all basic settings have been done you will need to fill in the blancs in your ```.env``` file.
A Google API key can be retrieved [here](https://developers.google.com/maps/documentation/javascript/get-api-key).


## Testing
To see if everything has gone as planned you can run the [installation test](https://github.com/Thorazine/hack/wiki/testing).


## Setup your site
Visit http://[domain]/cms and fill in the blancs.


## Example website
To get started you can seed the database with a simple Hack website. The seeder can be run by executing
```
php artisan db:seed --class=Thorazine\\Hack\\Database\\Seeds\\HackExampleSite
```
