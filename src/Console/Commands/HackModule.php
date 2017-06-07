<?php

namespace Thorazine\Hack\Console\Commands;

use Thorazine\Hack\Console\Generators\HackControllerGenerator;
use Thorazine\Hack\Console\Generators\HackModelGenerator;
use Illuminate\Console\Command;
use Exception;
use Artisan;

class HackModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hack:module {--name= : The name of the module} {--force : Overwrite if exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a starter module from template';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(HackControllerGenerator $controllerGenerator, HackModelGenerator $modelGenerator)
    {
        $this->controllerGenerator = $controllerGenerator;
        $this->modelGenerator = $modelGenerator;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->force = $this->option('force');

        $this->name = $this->option('name');

        $this->ascii();

        if(! $this->name) {
            $this->name = $this->ask('What will be the name of the module (example: SomeModuleName)?');
        }

        try {
            $this->controllerGenerator->fire($this->name, $this->force);
            $this->modelGenerator->fire($this->name, $this->force);

            $exitCode = Artisan::call('make:migration', [
                'name' => 'create_table_'.snake_case($this->name),
                // '--force' => $this->force,
                '--create' => snake_case($this->name),
            ]);
        }
        catch(Exception $e) {
            $this->error($e->getMessage());
        }

        $this->info('The files have been created. 
You now have to:

- add the rights
- configure the model
- update the migration
');
    }


    private function ascii()
    {
        $this->info(" _   _   ___  _____  _   __                     
| | | | / _ \/  __ \| | / /                     
| |_| |/ /_\ \ /  \/| |/ /    ___ _ __ ___  ___ 
|  _  ||  _  | |    |    \   / __| '_ ` _ \/ __|
| | | || | | | \__/\| |\  \ | (__| | | | | \__ \
\_| |_/\_| |_/\____/\_| \_/  \___|_| |_| |_|___/
");                              
    }
}
