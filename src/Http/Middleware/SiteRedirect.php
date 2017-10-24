<?php

namespace Thorazine\Hack\Http\Middleware;

use Thorazine\Hack\Models\Site;
use Closure;
use Cache;
use Cms;

class SiteRedirect
{

    private $domain = 'localhost';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if(in_array($request->route()->getName(), ['cms.base.first', 'cms.base.first.store'])) {
        //     return $next($request);
        // }

        // $this->domain = str_replace(['http://', 'https://'], ['', ''], $request->root());

        // // find the site
        // $site = Cache::tags(['sites'])->remember(implode('-', ['sites', $this->domain]), env('PAGE_CACHE_TIME', 1), function() {
        //     $site = Site::where('domain', $this->domain)
        //         ->orWhereRaw('FIND_IN_SET("'.$this->domain.'", domains)')
        //         ->orderBy('domain', '=', $this->domain, 'asc')
        //         ->first();

        //     return $site;
        // });

        // // check if it's first run, else just abort
        // if(! $site) {
        //     if(! Site::count()) {
        //         // dump('first');
        //         return redirect()->route('cms.base.first');
        //     }
        //     abort(404, 'Domain not found');
        // }

        // // redirect if not on main domain
        // if($request->root() != $site->protocol.$site->domain) {
        //     header("HTTP/1.1 301 Moved Permanently");
        //     header('Location: '.str_replace($request->root(), $site->protocol.$site->domain, $request->fullUrl()));
        //     die();
        // }

        // // check if site has been taken offline.
        // if($site->publish_at > date('Y-m-d H:i:s') && (is_null($site->depublish_at) || $site->depublish_at < date('Y-m-d H:i:s')) && strpos($request->fullUrl(), $site->protocol.$site->domain.'/cms') === false) {
        //     abort(404, 'Site not availible at this time.');
        // }

        // Cms::setSite($site);

        return $next($request);
    }
}
