<?php

namespace Thorazine\Hack\Console\Generators;

use Thorazine\Hack\Classes\Generator;

class HackBuilderGenerator extends Generator {
	
	protected $namespace = 'App\\Models\\Cms\\Builders';


	public function fire($name, $force = false) 
	{
		$this->name = $name;
		$this->force = $force;

		$this->setTemplate(__DIR__.'/../stubs/HackBuilder.stub');

		$this->replaceClassName();

		$this->replacePathName();

		$this->replaceUrlName();

		$this->replaceNameName();

		$this->replaceTableName();

		$this->create(base_path('app/Models/Cms/Builders'));
		
	}



}