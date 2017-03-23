<?php

namespace Thorazine\Hack\Classes;

use Thorazine\Hack\Models\Pageable;
use Thorazine\Hack\Models\Gallery;
use Thorazine\Hack\Models\Page;
use Thorazine\Hack\Models\Slug;
use Builder;
use Cms;
use DB;

class PageOutput {


	private $pageData;
	private $morphs;
	
	
	public function __construct(Page $page, Slug $slug, Pageable $pageable)
	{
		$this->page = $page;
        $this->slug = $slug;
    	$this->pageable = $pageable;
	}


	public function bySlug($slug)
	{
		
		$slug = $this->trimSlug($slug);

		$this->getPageBySlug($slug);

		$this->addSiteData();
		

		// If no page is found cache won't be saved. So we can just abort.
		if(! $this->pageData->view) {
			$this->pageData->view = 'default';
		}

		// check which relations are needed for this page
		$this->morps = $this->pageable
            ->select('pageable_type')
            ->where('page_id', $this->pageData->id)
            ->groupBy('pageable_type')
            ->pluck('pageable_type')
            ->toArray();

		// lazy load all relations that exist in the morph if they exist and put them in order
        foreach(array_keys(config('cms.modules')) as $relation) {

            if(in_array(config('cms.modules.'.$relation.'.namespace'), $this->morps)) {

                $namespace = config('cms.modules.'.$relation.'.namespace');
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


	private function getPageBySlug($slug)
	{
		// find the page
		$this->pageData = $this->page
            ->where('site_id', Cms::siteId())
			->where(DB::raw('CONCAT_WS("/", prepend_slug, slug)'), $slug)
			->published()
			->first();

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


	private function addSiteData()
	{
		// Add the site data to the output, overwrite what is non existant or empty
        $site = Cms::site();   

        if($this->pageData) {  
            $images = [];    
            foreach(Cms::site()->toArray() as $key => $value) {
                if(! $this->pageData->{$key}) {
                	if($site->types[$key]['type'] == 'image') {
                        $images[$value] = $key;
                	}
                	else {
                    	$this->pageData->{$key} = $value;
                    }
                }
            }

            // get all the images for this module
            $galleries = Gallery::whereIn('id', array_keys($images))->get();

            // assign them to ther respective input
            foreach($galleries as $gallery) {
                $this->pageData->{$images[$gallery->id]} = $gallery;
            }

            $this->pageData->site = Cms::site();            
        }
        else {
            Cms::abort(404);
        }

        return $this;
	}

}