<?php

namespace Thorazine\Hack\Classes;

use Thorazine\Hack\Models\NotFound;
use Thorazine\Hack\Models\Pageable;
use Thorazine\Hack\Models\Gallery;
use Thorazine\Hack\Classes\Search;
use Thorazine\Hack\Models\Page;
use Thorazine\Hack\Models\Slug;
use Request;
use Builder;
use Cache;
use Cms;
use DB;

class PageOutput {


	private $pageData;
	private $morphs;
	
	
	public function __construct(Page $page, Slug $slug, Pageable $pageable, Search $search)
	{
		$this->page = $page;
        $this->slug = $slug;
        $this->search = $search;
    	$this->pageable = $pageable;
	}


    /**
     * Get a page and builders by it's slug
     */
	public function bySlug($slug, $withRestrictions = true)
	{
		$slug = $this->trimSlug($slug);

		$this->getPageBySlug($slug, Cms::getSiteLanguage(), $withRestrictions);

        // set the language
        Cms::setSiteLanguage($this->pageData['language']);

		$this->addSiteData($slug);

		// set the default view
		if(! $this->pageData->view) {
			$this->pageData->view = 'default';
		}
        elseif(in_array($this->pageData->view, config('cms.search.view_bind'))) {
            $this->pageData->search = $this->search->get();
        }

		// check which relations are needed for this page
		$this->morps = $this->pageable
            ->select('pageable_type')
            ->where('page_id', $this->pageData->id)
            ->groupBy('pageable_type')
            ->pluck('pageable_type')
            ->toArray();

		// lazy load all relations that exist in the morph if they exist and put them in order
        foreach(array_keys(config('cms.builders')) as $relation) {

            if(in_array(config('cms.builders.'.$relation.'.namespace'), $this->morps)) {

                $namespace = config('cms.builders.'.$relation.'.namespace');
                $builderClass = new $namespace();

                // lazy load with the frontend scope (extended functionality)
                $this->pageData->load([str_plural($relation) => function($query) {
                    $query->frontend();
                }]);

                // replace the frontend values with the proper ones
                foreach($this->pageData->{str_plural($relation)} as $builder) {
                    $this->pageData->{$builder->key} = $builderClass->replaceFrontendValue($this->pageData->{$builder->key}, $builder);
                }
            }
        }

        // put the page data in a flash variable and return it
        Cms::setPage($this->pageData);

        return $this->pageData;
	}


	public function trimSlug($slug)
	{
		// the query will always have a slash because of the combine
        // so we need to give the slug at least one slash to match
        $slug = trim($slug, '/');
        // if(strpos($slug, '/') === false) {
        //     $slug = '/'.$slug;
        // }

        return $slug;
	}


	private function getPageBySlug($slug, $language = false, $withRestrictions = true)
	{
		// find the page
		$this->pageData = $this->page
			->where(DB::raw('TRIM(BOTH "/" FROM CONCAT_WS("/", prepend_slug, slug))'), $slug);
        
        // if we need the delimiter
        if($withRestrictions) {
			$this->pageData = $this->pageData->published();
        }

        if($language) {
        	$this->pageData = $this->pageData->where('language', Cms::getSiteLanguage());
        }

		$this->pageData = $this->pageData->first();

		// if the page isn't found we will search for the latest previous matching slug
		if(! $this->pageData) {
			$slug = $this->slug
				->where('slug', $slug)
				->orderBy('created_at', 'desc')
				->with('page')
				->first();

			// if found redirect away permanently
			if($slug) {
                return [
                    'abort' => 301,
                    'attribute' => route('page', ['slug' => $slug->page->prepend_slug.'/'.$slug->page->slug])
                ];
    		}
            else {
                return [
                    'abort' => 404,
                ];
            }
		}

		return $this;
	}


	private function addSiteData($slug)
	{
		// Add the site data to the output, overwrite what is non existant or empty
        $site = Cms::site();   


        if($this->pageData) {  
            $images = [];    
            foreach(Cms::site()->toArray() as $key => $value) {
                if(! $this->pageData->{$key}) {
                	if(@$site->types[$key]['type'] == 'image') {
                        $images[$value] = $key;

                        // give each image a gallery placeholder
                        $this->pageData->{$key} = new Gallery;
                	}
                	else {
                    	$this->pageData->{$key} = $value;
                    }
                }
            }

            // get all the images for this module
            $galleries = Gallery::whereIn('id', array_keys($images))->get();

            // assign them to their respective input, replacing the placeholder
            foreach($galleries as $gallery) {
                $this->pageData->{$images[$gallery->id]} = $gallery;
            }

            $this->pageData->site = Cms::site();   
        }
        else {
            
            if(! Cms::getNotFound()) {
                NotFound::add($slug); // Add to 404 table
                Cms::setNotFound();

                $page = Cache::tags('pages', 'templates', 'slugs')->remember(Cms::cacheKey(['page', '404', Cms::siteId()]), env('PAGE_CACHE_TIME', 1), function() {
                    return $this->bySlug('404');
                });

                if($page) {
                    return $page;
                    return view(Cms::siteId().'.error')
                        ->with('page', $page)
                        ->render();
                }
            }

            Cms::abort(404, 'Slug not found');
        }

        return $this;
	}

}