<?php

namespace Thorazine\Hack\Console\Commands;

use Thorazine\Hack\Models\Site;
use Illuminate\Console\Command;

class HackInstallation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hack:install {--force : Overwrite if exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tries to do the hack installation.';

    /**
     * The content from the open file
     * @var string
     */
    protected $content;

    /**
     * The file that is currently being edited
     * @var string
     */
    protected $file;

    /**
     * Do we force the overwrite
     * @var boolean
     */
    protected $force = false;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	// set the force
        $this->force = $this->option('force');
    	$this->ascii();        
    	$this->runCommands();
        $this->updateApp();
        $this->updateEnv();
        $this->updateDatabase();
    }

    /**
     * Run all the artisan commands
     */
    private function runCommands()
    {
    	$this->call('storage:link');

    	$this->call('migrate');

		$this->call('vendor:publish', [
	    	'--tag' => 'hack',
	    	'--force' => $this->force
	    ]);
    }

    /**
     * Update the config.app
     */
    private function updateApp()
    {
    	$this->get(base_path('config/app.php'))

    		// add to providers
    		->insert([
    			'Collective\Html\HtmlServiceProvider::class,',
    			'Barryvdh\Debugbar\ServiceProvider::class,',
    			'Thorazine\Hack\Providers\RouteServiceProvider::class,',
    			'Thorazine\Hack\Providers\BuilderServiceProvider::class,',
    			'Thorazine\Hack\Providers\CmsServiceProvider::class,',
    			'Thorazine\Hack\Providers\FrontServiceProvider::class,',
    			'Thorazine\Hack\Providers\ValidationServiceProvider::class,',
    			'Intervention\Image\ImageServiceProvider::class,',
    			'Cartalyst\Sentinel\Laravel\SentinelServiceProvider::class,',
    			'Jenssegers\Agent\AgentServiceProvider::class,',
    			'Maatwebsite\Excel\ExcelServiceProvider::class,',
    			'Thorazine\Location\LocationServiceProvider::class,',
    		], 
    		'Thorazine\Hack\HackServiceProvider::class,', 
    		'		', 
    		PHP_EOL)

    		// add to aliases
    		->insert([
				"'Form' => Collective\Html\FormFacade::class,",
			    "'Html' => Collective\Html\HtmlFacade::class,",
			    "'Debugbar' => Barryvdh\Debugbar\Facade::class,",
			    "'Image' => Intervention\Image\Facades\Image::class,",
			    "'Activation' => Cartalyst\Sentinel\Laravel\Facades\Activation::class,",
			    "'Reminder' => Cartalyst\Sentinel\Laravel\Facades\Reminder::class,",
			    "'Sentinel' => Cartalyst\Sentinel\Laravel\Facades\Sentinel::class,",
			    "'Excel' => Maatwebsite\Excel\Facades\Excel::class,",
			    "'Builder' => Thorazine\Hack\Facades\BuilderFacade::class,",
			    "'Cms' => Thorazine\Hack\Facades\CmsFacade::class,",
			    "'Front' => Thorazine\Hack\Facades\FrontFacade::class,",
			    "'Location' => Thorazine\Location\Facades\LocationFacade::class,",
    		],
    		"'View' => Illuminate\Support\Facades\View::class,",
    		'		')
    		->write();
    }

    /**
     * Update the .env file
     */
    private function updateEnv()
    {
    	$this->get(base_path('.env'))
    		->insert([
    			'GOOGLE_KEY' => 'GOOGLE_KEY=',
    			'PAGE_CACHE_TIME' => 'PAGE_CACHE_TIME=0',
    			'FILESYSTEM_DRIVER' => 'FILESYSTEM_DRIVER=public'
    		])
    		->replace('CACHE_DRIVER=file', 'CACHE_DRIVER=array')
    		->replace('MAIL_HOST=smtp.mailtrap.io', 'MAIL_HOST=127.0.0.1')
    		->replace('MAIL_PORT=2525', 'MAIL_PORT=1025')
    		->write();
    }

    /**
     * Update the config.database
     */
    private function updateDatabase() 
    {
    	$this->get(base_path('config/database.php'))
    		->replace("'strict' => true,", "'strict' => false,")
    		->write();
    }

    /**
     * Get a file and read the content
     * @param  string $file path to file
     * @return class
     */
    private function get($file)
    {
    	$this->file = $file;

    	$this->content = file_get_contents($this->file);

    	return $this;
    }

    /**
     * Insert text in the content
     * @param  array   $replacers All that needs to be replaced
     * @param  string $after   	  After which string do we insert
     * @param  string  $prepend   Place before insert
     * @param  string  $append    Place after insert
     * @return class
     */
    private function insert(array $replacers, $after = false, $prepend = '', $append = PHP_EOL)
    {
    	$insert = '';

    	// check if the entry already exists
    	foreach($replacers as $find => $replacer) {
    		if(is_string($find)) {
    			if(! $this->has($find)) {
    				$insert .= $prepend.$replacer.$append;
    			}
    		}
    		else {
    			if(! $this->has($replacer)) {
    				$insert .= $prepend.$replacer.$append;
    			}
	    	}
    	}

    	if($insert) {
    		// replace or push on the end
    		if($after) {
    			$insert = $after.PHP_EOL.$insert;
    			$this->content = str_replace($after, $insert, $this->content);
    		}
    		else {
    			$this->content .= PHP_EOL.$insert;
    		}
    	}
    	
    	return $this;
    }

    /**
     * Find and replace a text in the content
     * @param  string $find    Find
     * @param  string $replace replace
     * @return class
     */
    private function replace($find, $replace)
    {
    	if($this->has($find)) {
    		$this->content = str_replace($find, $replace, $this->content);
    	}
    	return $this;
    }

    /**
     * Does content contain
     * @param  string  $find What you want to find
     * @return boolean
     */
    private function has($find)
    {
    	return (strpos($this->content, $find) !== false) ? true : false;
    }

    /**
     * Put the new content in the file
     */
    private function write()
    {
    	file_put_contents($this->file, $this->content);
    }

    /**
     * Shameless console promotion
     */
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
