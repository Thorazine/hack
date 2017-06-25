<?php

namespace Thorazine\Hack\Classes;

use Thorazine\Hack\Models\SearchIndex;
use Thorazine\Hack\Models\Page;
use Thorazine\Hack\Models\Site;
use Storage;
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


        if($q) {
            $search = $this->searchIndex
                ->where(function($query) use ($q) {
                    foreach($this->queryToArray($q) as $qpart) {
                        $query = $query->where('value', 'LIKE', '%'.$qpart.'%');
                    }
                    return $query;
                })
                ->orderBy('search_priority', 'desc')
            	->groupBy('page_id')
                ->orderBy('publish_date', 'desc')
                ->paginate(10);

            return $search;
        }

        return false;
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
        $searchTypes = config('cms.search.frontend_search_types');

        $sites = $this->site->get();

        $entries = [];
        $sitemapData = [];
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

                    if($page->publish_at < $date && (is_null($page->depublish_at) || $page->depublish_at > $date) && $page->search_priority > 0) {

                        // create the page url
                        $url = $domain.'/'.ltrim($page->prepend_slug.'/'.$page->slug, '/');

                        // add the page itself
                        array_push($entries, [
                            'page_id' => $page->id,
                            'title' => $page->title,
                            'body' => Front::str_short(strip_tags($page->body)),
                            'url' => $url,
                            'value' => strip_tags($page->body),
                            'search_priority' => $page->search_priority,
                            'publish_date' => $page->publish_at,
                            'created_at' => $date,
                            'updated_at' => $date,
                        ]);

                        array_push($sitemapData, [
                            'url' => $url,
                            'updated_at' => $page->updated_at->format('Y-m-d'),
                            'priority' => round(($page->search_priority / 10), 1),
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
                                    'url' => $url,
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

        $sitemap = view('hack::tools.sitemap')->with('pages', $sitemapData)->render();

        Storage::disk(config('filesystems.default'))->put('sitemaps/'.Cms::siteId().'/sitemap.xml', $sitemap);
    }

}