<?php

namespace Thorazine\Hack\Console\Generators;

use Thorazine\Hack\Classes\Generator;

class HackMigrationGenerator extends Generator {
	
	protected $namespace = 'Database';


	public function fire($name, $force = false) 
	{
		$this->name = $name;
		$this->force = $force;

		$this->filename = date('Y_m_d_His').'_create_table_builder_'.snake_case($this->name).'.php';

		$this->setTemplate(__DIR__.'/../stubs/HackMigration.stub');

		$this->replaceClassName('CreateTableBuilder'.studly_case($this->name));

		$this->replaceTableName('builder_'.snake_case(str_plural($this->name)));

		$this->create(base_path('database/migrations'));
		
	}



}