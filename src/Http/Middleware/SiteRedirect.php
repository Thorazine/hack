<?php

namespace Thorazine\Hack\Http\Middleware;

use Thorazine\Hack\Models\Site;
use Closure;
use Cache;
use Hack;

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
        if(in_array($request->route()->getName(), ['hack.first.index', 'hack.api.first.store'])) {
            return $next($request);
        }

        $this->domain = str_replace(['http://', 'https://'], ['', ''], $request->root());

        // find the site
        $site = Cache::tags(['sites'])->remember(implode('-', ['sites', $this->domain]), env('PAGE_CACHE_TIME', 1), function() {
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
                return redirect()->route('hack.first.index');
            }
            abort(404, 'Domain not found');
        }

        // redirect if not on main domain
        if($request->root() != $site->protocol.$site->domain) {
            header("HTTP/1.1 301 Moved Permanently");
            header('Location: '.str_replace($request->root(), $site->protocol.$site->domain, $request->fullUrl()));
            die();
        }

        // check if site has been taken offline.
        if($site->publish_at > date('Y-m-d H:i:s') && (is_null($site->depublish_at) || $site->depublish_at < date('Y-m-d H:i:s')) && strpos($request->fullUrl(), $site->protocol.$site->domain.'/hack') === false) {
            abort(404, 'Site not availible at this time.');
        }

        Hack::setSite($site);

        return $next($request);
    }
}
