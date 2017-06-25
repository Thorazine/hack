<?php

namespace Thorazine\Hack\Classes;

use Thorazine\Hack\Models\SearchIndex;
use Thorazine\Hack\Models\Page;
use Thorazine\Hack\Models\Site;
use Request;
use Front;
use Cms;
use DB;

class Search {

	public function __construct(SearchIndex $searchIndex, Site $site, Page $page)
	{
        $this->site = $site;
        $this->page = $page;
		$this->searchIndex = $searchIndex;
	}


	
	public function get()
	{
		$q = Request::get('q');

        $search = $this->searchIndex;

        if($q) {
	        $search = $search->where(function($query) use ($q) {
                    foreach($this->queryToArray($q) as $qpart) {
                        $query = $query->where('value', 'LIKE', '%'.$qpart.'%');
                    }
                    return $query;
                });

	    }

        $search = $search->orderBy('search_priority', 'desc')
        	->groupBy('page_id')
            ->orderBy('publish_date', 'desc')
            ->paginate(10);

        return $search;
	}

	/*
	 * Split the query on quotes
	 */
    private function queryToArray($q)
    {
        $query = $q;

        preg_match_all('/"(?:\\\\.|[^\\\\"])*"|\S+/', $query, $matches);

        return $this->removeQuotes($matches[0]);
    }

    /*
	 * Trim and push all the query parts 
	 */
    private function removeQuotes($parts)
    {
        $matches = [];

        foreach($parts as $part) {
            array_push($matches, trim($part, '"'));
        }

        return $matches;
    }


    public function pageIndex()
    {
        // get the builder types we want to be able to search for
        $searchTypes = config('cms.search.frontendSearchTypes');

        $sites = $this->site->get();

        $entries = [];
        $date = date('Y-m-d H:i:s');


        foreach($sites as $site) {
            Cms::setSite($site);

            if($site->publish_at < $date && (is_null($site->depublish_at) || $site->depublish_at > $date)) {
                $domain = Cms::site('protocol').Cms::site('domain');

                // start query
                $pages = $this->page;

                // attach the wanted builders
                foreach($searchTypes as $searchType) {
                    $pages = $pages->with(str_plural($searchType));
                }

                // get records
                $pages = $pages->get();

                // loop through all the pages
                foreach($pages as $page) {

                    if($page->publish_at < $date && (is_null($page->depublish_at) || $page->depublish_at > $date)) {

                        // add the page itself
                        array_push($entries, [
                            'page_id' => $page->id,
                            'title' => $page->title,
                            'body' => Front::str_short(strip_tags($page->body)),
                            'url' => $domain.'/'.ltrim($page->prepend_slug.'/'.$page->slug, '/'),
                            'value' => strip_tags($page->body),
                            'search_priority' => $page->search_priority,
                            'publish_date' => $page->publish_at,
                            'created_at' => $date,
                            'updated_at' => $date,
                        ]);

                        // extract builders from page
                        foreach($searchTypes as $searchType) {
                            $builders = $page->{str_plural($searchType)};

                            // loop through builders
                            foreach($builders as $builder) {

                                // Add the builders
                                array_push($entries, [
                                    'page_id' => $page->id,
                                    'title' => $page->title,
                                    'body' => Front::str_short(strip_tags($page->body)),
                                    'url' => $domain.'/'.ltrim($page->prepend_slug.'/'.$page->slug, '/'),
                                    'value' => strip_tags($builder->value),
                                    'search_priority' => $page->search_priority,
                                    'publish_date' => $page->publish_at,
                                    'created_at' => $date,
                                    'updated_at' => $date,
                                ]);
                            }
                        }
                    }
                }
            }
        }
        $this->searchIndex->truncate();
        $this->searchIndex->insert($entries);
    }

}