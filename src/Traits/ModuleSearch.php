<?php

namespace Thorazine\Hack\Traits;

// use Illuminate\Foundation\Application;
use Cms;
use Log;
use DB;

trait ModuleSearch {
	
	protected $defaultSearchTypes = [];

	/**
	 * 
	 */
	protected $searchFields = [];

	/**
	 * 
	 */
	protected $searchDirection = 'desc';


	private $searchQuery;
	private $searchRequest;


	protected function search($query, $request)
	{
		$this->searchQuery = $query;
		$this->searchRequest = $request;
		$this->setDefaultSearchTypes();


		$this->addQuery()->addOrder();

		return $this->searchQuery;
	}


	protected function setDefaultSearchTypes()
	{
		if(! count($this->searchFields)) {
			if(! count($this->defaultSearchTypes)) {
				$this->defaultSearchTypes = config('cms.search.defaultSearchTypes');
			}

			foreach($this->model->types as $key => $values) {
				if(in_array($values['type'], $this->defaultSearchTypes)) {
					array_push($this->searchFields, $key);
				}
			}
		}
	}


	protected function addQuery()
	{
		if($this->searchRequest->q) {

			$this->searchQuery = $this->searchQuery->where(function($query) {

				// split the query in parts
                foreach($this->queryToArray() as $qpart) {

                	$query->where(function($query) use ($qpart) {

	                	// do this for all search fields
                		foreach($this->searchFields as $column) {
	                		// get the fields we need to search through
	                    	$query = $query->orWhere($column, 'LIKE', '%'.$qpart.'%');
	                   	}

                		return $query;
	                });
                }
                return $query;
            });

		}

		return $this;
	}


	private function queryToArray()
    {
        $this->query = $this->searchRequest->q;

        preg_match_all('/"(?:\\\\.|[^\\\\"])*"|\S+/', $this->query, $matches);

        return $this->removeQuotes($matches[0]);
    }


    private function removeQuotes($parts)
    {
        $matches = [];

        foreach($parts as $part) {
            array_push($matches, trim($part, '"'));
        }

        return $matches;
    }


    protected function addOrder()
    {
    	if($this->searchRequest->order && in_array($this->searchRequest->order, $this->searchFields)) {
    		$this->searchQuery = $this->searchQuery
    			->orderBy($this->searchRequest->order, $this->getDirection());
    	}

    	return $this;
    }


    protected function getDirection()
    {
    	if($this->searchRequest->dir) {
    		return $this->searchRequest->dir;
    	}

    	return $this->searchDirection;
    }

}