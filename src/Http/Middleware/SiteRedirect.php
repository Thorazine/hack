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
        if(in_array($request->route()->getName(), ['cms.base.first', 'cms.base.first.store'])) {
            return $next($request);
        }

        $this->domain = str_replace(['http://', 'https://'], ['', ''], $request->root());

        // find the site
        $site = Cache::tags(['site'])->remember(implode('-', ['site', $this->domain]), env('PAGE_CACHE_TIME'), function() {
            $site = Site::where('domain', $this->domain)
                ->orWhereRaw('FIND_IN_SET("'.$this->domain.'", domains)')
                ->orderBy('domain', '=', $this->domain, 'asc')
                ->first();
                
            return $site;
        });

        // check if it's first run, else just abort
        if(! $site) {
            if(! Site::count()) {
                // dump('first');
                return redirect()->route('cms.base.first');
            }
            abort(404, 'Domain not found');
        }

        if($request->root() != $site->protocol.$site->domain) {
            header("HTTP/1.1 301 Moved Permanently");
            header('Location: '.str_replace($request->root(), $site->protocol.$site->domain, $request->fullUrl()));
            die();
        }

        Cms::setSite($site);

        return $next($request);
    }
}
