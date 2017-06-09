<?php

namespace Thorazine\Hack\Console\Generators;

use Thorazine\Hack\Classes\Generator;

class HackControllerGenerator extends Generator {
	
	protected $namespace = 'App\\Http\\Controllers\\Cms\\';


	public function fire($name, $force) 
	{
		$this->name = $name;
		$this->force = $force;

		$this->filename = studly_case($this->name).'Controller.php';

		$this->setTemplate(__DIR__.'/../stubs/HackController.stub');

		$this->replaceClassName()->replacePathName()->replaceUrlName()->replaceSlugName();

		$this->create(base_path('app/Http/Controllers/Cms'));		
	}



}