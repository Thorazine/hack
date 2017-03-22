<?php

namespace Thorazine\Hack\Classes\Builders;

class Form {
	
	private $parent;


	public function __construct($parent)
	{
		$this->form = $parent;

	}


	public function test($text)
	{
		dd($text);

		return $this;
	}


	/**
	 * Create a little magic. Make the parent
	 * variables availible in this function
	 */
	public function __get($method)
	{
		if(@$this->parent->$method) {
			return $this->parent->$method;
		}
	}
}