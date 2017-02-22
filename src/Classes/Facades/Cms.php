<?php

namespace Thorazine\Hack\Classes\Facades;

use Thorazine\Hack\Models\Gallery;
use Thorazine\Hack\Models\Site;
use Cache;

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
	 * Cached version of the gallery
	 */
	private $gallery;


	private $menuOpen = false;


	/**
	 * Get the site id of the current site
	 *
	 * @return int
	 */
	public function site($attribute = false)
	{
		if($attribute) {
			return $this->site->{$attribute};
		}
		return $this->site;
	}


	/**
	 * Get the site id of the current site
	 *
	 * @param collection
	 */
	public function setSite($collection)
	{
		$this->site = $collection;
	}


	/**
	 * Get the site id of the current site
	 *
	 * @return int
	 */
	public function siteId()
	{
		return $this->site['id'];
	}


	/**
	 * Get all the sites
	 *
	 * @return collection
	 */
	public function sites()
	{
		return Site::select('id', 'title')
            ->orderBy('title', 'asc')
            ->get();
	}

	


	/**
	 * Get the domain of the current site
	 *
	 * @return int
	 */
	public function siteDomain()
	{
		return $this->site['domain'];
	}


	/**
	 * Get the user
	 *
	 * @return int
	 */
	public function user($attribute = false)
	{
		if($attribute) {
			return $this->user->{$attribute};
		}
		return $this->user;
	}


	/**
	 * Get the user
	 *
	 * @return int
	 */
	public function roles($attribute = false)
	{
		if($attribute) {
			return $this->user->roles->{$attribute};
		}
		return $this->user->roles;
	}


	/**
	 * Get the user id of the current user
	 *
	 * @param collection
	 * @return collection (user)
	 */
	public function setUser($collection)
	{
		$this->user = $collection;

		return $this->user;
	}


	/**
	 * Add persistence data to the user
	 *
	 * @param collection
	 * @return collection (user)
	 */
	public function setPersistence($collection)
	{
		$this->user->persistence = $collection;

		return $this->user;
	}


	/**
	 * Get the user id of the current user
	 *
	 * @return int
	 */
	public function userId()
	{
		return $this->user['id'];
	}


	/**
	 * Set the users rights as an array
	 *
	 * @param array  $rights
	 * @return array
	 */
	public function setRights($rights)
	{
		$this->rights = $rights;

		return $this->rights;
	}


	/**
	 * Set the users rights as an array
	 *
	 * @param array  $rights
	 * @return array
	 */
	public function hasPermission($permission)
	{
		return in_array($permission, $this->rights);		 
	}


	/**
	 * Get all the site id's from the session where the slug matches
	 *
	 * @param array  $rights
	 * @return array
	 */
	public function sitePermission($slug)
	{
		return array_reduce($this->rights, function($m, $str) use ($slug) {
			if (preg_match ('/^(\w+)\.cms\.'.$slug.'\.index/i', $str, $matches))
		    $m[] = $matches[1];

			return $m;
		}, []);		
	}



	/**
	 * Get the user id of the current user
	 *
	 * @return int
	 */
	public function setCode($request)
	{
		if($request->session()->has(config('cartalyst.sentinel.session'))) {
            $this->code = $request->session()->get(config('cartalyst.sentinel.session'));
        }
        elseif($code = $request->cookie(config('cartalyst.sentinel.session'))) {
            $this->code = $code;
        }
        return $this->code;
	}


	/**
	 * Get the user id of the current user
	 *
	 * @return int
	 */
	public function code()
	{
		return $this->code;
	}


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
        Cache::tags($keys)->flush();;
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


    public function getGallery()
    {
        if(! $this->gallery) {
            $this->gallery = new Gallery;
        }
        return $this->gallery;
    }


    public function getSubMenu($children)
    {
    	$html = '';
    	foreach($children as $child) {
			if(@$child['route']) {
                $html .= view('cms.partials.sub-menu')
                	->with('child', $child)
                	->render();
			}
		}
		return $html;
    }


    public function setMenuOpen($state)
    {
    	$this->menuOpen = $state;
    }


    public function getMenu()
    {
    	return $this->menuOpen;
    }

}