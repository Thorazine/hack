<?php

namespace Thorazine\Hack\Http\Middleware;

use Closure;
use Cms;

class LanguageRedirect
{
    /**
     * Filter the language from the slug and 
     * redirect to a language if needed
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // only redirect on get requests
        if($request->isMethod('get')) {

        	$slug = str_replace($request->root(), '', $request->fullUrl());

        	// grab segment 1 and see if it's a language
        	if(in_array($request->segment(1), Cms::site('languages'))) {

        		if(substr($slug, 0, 1) === '/') {
        			$slug = '/'.ltrim(substr($slug, strlen($request->segment(1)) + 1), '/');
        		}
        		else {
        			$slug = '/'.ltrim(substr($slug, strlen($request->segment(1))), '/');
        		}

        		Cms::setSlug($slug);

        		// set the current language
        		Cms::setSiteLanguage($request->segment(1));

        		// go to the original request
        	    return $next($request);
        	}

        	// no match on the language. So figure out which one to get
        	$locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

        	// if browser language matchaes a language
        	if(in_array($locale, Cms::site('languages'))) {

        		// set the language 
        		Cms::setSiteLanguage($locale);

        		return redirect($request->root().'/'.$locale.$slug);
        	}

        	// set the language 
        	Cms::setSiteLanguage(Cms::site('language'));

        	// redirect the user to the default site language
        	return redirect($request->root().'/'.Cms::site('language').$slug);
        }
        
        return $next($request);        
    }
}
