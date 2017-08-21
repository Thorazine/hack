<?php

namespace Thorazine\Hack\Classes;

use Exception;

abstract class Generator {
	
	protected $namespace = 'App';
	protected $name = '';
	protected $filename;
	protected $template;
	protected $force;
	abstract protected function fire($name, $force);


	protected function namespaceToPath()
	{
		return $this->namespace;
	}


	protected function filename()
	{
		if(! empty($this->filename)) {
			return $this->filename;
		}
		else {
			$this->filename = studly_case($this->name).'.php';
		}
		return $this->filename;
	}


	protected function replaceClassName($name = false)
	{
		if($name) {
			$this->template = str_replace('DummyClass', $name, $this->template);
		}
		else {
			$this->template = str_replace('DummyClass', studly_case($this->name), $this->template);
		}
		
		return $this;
	}


	protected function replacePathName()
	{
		$this->template = str_replace('DummyPath', snake_case(str_plural($this->name)), $this->template);
		return $this;
	}


	protected function replaceUrlName()
	{
		$this->template = str_replace('DummyUrl', snake_case($this->name), $this->template);
		return $this;
	}


	protected function replaceSlugName()
	{
		$this->template = str_replace('DummySlug', snake_case(str_plural($this->name)), $this->template);
		return $this;
	}


	protected function replaceNameName()
	{
		$this->template = str_replace('DummyName', snake_case($this->name), $this->template);
		return $this;
	}


	protected function replaceTableName($name = false)
	{
		if($name) {
			$this->template = str_replace('DummyTable', $name, $this->template);
		}
		else {
			$this->template = str_replace('DummyTable', snake_case(str_plural($this->name)), $this->template);
		}

		return $this;
	}


	protected function setTemplate($path)
	{
		if(file_exists($path)) {
			$this->template = file_get_contents($path) or die('No such template.');
		}
		else {
			die('Template does not exist.');
		}
		
		return $this;
	}


	protected function create($path)
	{
		if(file_exists($path.'/'.$this->filename()) && ! $this->force) {
			throw new Exception('Conflict: File already exists');
		}


		if(! is_dir($path)) {
			// dir doesn't exist, make it
			mkdir($path, 0755, true);
		}

		file_put_contents($path.'/'.$this->filename(), $this->template);
	}

}