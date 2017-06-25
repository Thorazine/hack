<?php

namespace Thorazine\Hack\Classes;

use Thorazine\Hack\Models\SearchIndex;
use Request;
use DB;

class Search {

	public function __construct(SearchIndex $searchIndex)
	{
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

}