<?php

namespace Thorazine\Hack\Console\Commands;

use Thorazine\Hack\Models\Site;
use Illuminate\Console\Command;

class UpdateRehash extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hack:rehash';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the hash for the static scripts after deployment to bust the browser cache.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Site $site)
    {
        parent::__construct();
        
        $this->site = $site;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->site->update([
            'browser_cache_hash' => crc32(microtime()),
        ]);
    }
}
