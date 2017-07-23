<?php

namespace Thorazine\Hack\Console\Commands;

use Thorazine\Hack\Console\Generators\HackMigrationGenerator;
use Thorazine\Hack\Console\Generators\HackBuilderGenerator;
use Illuminate\Console\Command;
use Artisan;

class HackBuilder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hack:builder {--name= : The name of the module} {--force : Overwrite if exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a starter for a builder type.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(HackBuilderGenerator $builderGenerator, HackMigrationGenerator $migrationGenerator)
    {
        $this->builderGenerator = $builderGenerator;
        $this->migrationGenerator = $migrationGenerator;

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
            $this->name = $this->ask('What will be the name of the builder (example: SomeBuilderName)?');
        }

        try {
            $this->builderGenerator->fire($this->name, $this->force);
            $this->migrationGenerator->fire($this->name, $this->force);

            // $exitCode = Artisan::call('make:migration', [
            //     'name' => 'create_table_builder_'.snake_case($this->name),
            //     // '--force' => $this->force,
            //     '--create' => snake_case($this->name),
            // ]);
        }
        catch(Exception $e) {
            $this->error($e->getMessage());
        }

        $this->info('The files have been created. 
You now have to:

- add the rights (config/rights.php)
- update modules (config/cms.php)
- update menu (config/menu.php)
- configure the builder 
- update the migration

For more information go to https://github.com/Thorazine/hack/wiki/Adding-a-custom-builder
');
    }


    private function ascii()
    {
        // http://patorjk.com/software/taag/#p=display&f=Slant&t=HACK%20cms
        $this->info("    __  _____   ________ __                       
   / / / /   | / ____/ //_/   _________ ___  _____
  / /_/ / /| |/ /   / ,<     / ___/ __ `__ \/ ___/
 / __  / ___ / /___/ /| |   / /__/ / / / / (__  ) 
/_/ /_/_/  |_\____/_/ |_|   \___/_/ /_/ /_/____/  
                                                  
");                              
    }
}
