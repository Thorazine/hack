<?php

namespace Thorazine\Hack\Console\Commands;

use Thorazine\Hack\Classes\Search;
use Illuminate\Console\Command;

class HackSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hack:search';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index all the pages for the search and sitemap system';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Search $search)
    {
        $this->search = $search;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->search->pageIndex();
    }
}
