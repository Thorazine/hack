<?php

namespace Thorazine\Hack\Console\Generators;

use Thorazine\Hack\Classes\Generator;

class HackControllerGenerator extends Generator {
	
	protected $namespace = 'App\\Http\\Controllers\\Cms\\';


	public function fire($name, $force) 
	{
		$this->name = $name;
		$this->force = $force;

		$this->setTemplate(__DIR__.'/../stubs/HackController.stub');

		$this->replaceClassName()->replacePathName()->replaceUrlName();

		$this->create(base_path('app/Http/Controllers/Cms'));		
	}



}