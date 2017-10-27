<?php

namespace Thorazine\Hack\Http\Middleware;

use Thorazine\Hack\Models\Auth\HackPersistence;
use Thorazine\Hack\Scopes\SiteScope;
use Sentinel;
use Closure;
use Hack;

class SentinelIsNotAuthenticated
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Sentinel::check()) {
            return redirect()->route('hack.overview.index');
        }
        return $next($request);
    }
}
