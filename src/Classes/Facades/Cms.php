<?php

namespace Thorazine\Hack\Classes\Facades;

use Thorazine\Hack\Classes\PageOutput;
use Thorazine\Hack\Models\Gallery;
use Thorazine\Hack\Models\Site;
use Exception;
use Cache;
use App;

class Cms {

	/**
	 * The site data
	 */
	private $site;

	/**
	 * The user data
	 */
	private $user;

	/**
	 * The users rights
	 */
	private $rights;

	/**
	 * The persistence code
	 */
	private $code;

	/**
	 * The site data
	 */
	private $page;


	/**
	 * Create a cache key from an array
	 *
	 * @param array $keys
	 * @return string
	 */
	public function cacheKey(array $keys = [])
    {
        return implode('-', $keys);
    }


	/**
	 * Create a cache key from an array
	 *
	 * @param array $keys
	 * @return string
	 */
	public function destroyCache(array $keys = [])
    {
    	// since this is a frontend cache remover and this only gets called
    	// when frontend stuf gets changed, we will always flush page.
    	array_push($keys, 'pages');
        Cache::tags($keys)->flush();
    }


    /**
	 * Handle the aborts
	 *
	 * @param int $code
	 * @param array $attributes
	 * @return void
	 */
    public function abort($code, $attributes = [])
    {
        switch ($code) {
            case 404:
                abort(404);
                break;

            case 301:
            	if(! @$attributes['url']) {
            		$this->abort(404);
            	}
                header("HTTP/1.1 301 Moved Permanently");
                header('Location: '.$attributes['url']);
                die();
                break;

            default:
                abort(404);
        }

    }

    /*
     * Get the package version
     */
    public function getVersion()
    {
    	try {
	    	return Cache::remember('version', 60, function() {
	    		$content = json_decode(file_get_contents(base_path('composer.lock')), true);

		    	foreach($content['packages'] as $package) {
		    		if($package['name'] == 'thorazine/hack') {
		    			return $package['version'];
		    			break;
		    		}
		    	}
	    	});
	    }
	    catch(Exception $e) {
	    	return '0.0.0';
	    }
    }

}
