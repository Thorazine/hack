<?php

namespace Thorazine\Hack\Console\Generators;

use Thorazine\Hack\Classes\Generator;

class HackModelGenerator extends Generator {
	
	protected $namespace = 'App\\Models\\Cms';


	public function fire($name, $force = false) 
	{
		$this->name = $name;
		$this->force = $force;

		$this->setTemplate(__DIR__.'/../stubs/HackModel.stub');

		$this->replaceClassName();

		$this->replacePathName();

		$this->replaceUrlName();

		$this->replaceTableName();

		$this->create(base_path('app/Models/Cms'));
		
	}



}