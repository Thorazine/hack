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
	        $search = $search->where('value', 'LIKE', '%'.$q.'%');
	    }

        $search = $search->orderBy('search_priority', 'desc')
        	->groupBy('page_id')
            ->orderBy('publish_date', 'desc')
            ->paginate(10);

        return $search;
	}

}