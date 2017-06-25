<?php

namespace Thorazine\Hack\Console\Commands;

use Thorazine\Hack\Models\SearchIndex;
use Thorazine\Hack\Scopes\SiteScope;
use Thorazine\Hack\Models\Pageable;
use Thorazine\Hack\Models\Page;
use Thorazine\Hack\Models\Site;
use Illuminate\Console\Command;

use Exception;
use Artisan;
use Front;
use Cms;
use DB;

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
    public function __construct(Site $site, Page $page, SearchIndex $searchIndex)
    {
        $this->site = $site;
        $this->page = $page;
        $this->searchIndex = $searchIndex;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // get the builder types we want to be able to search for
        $searchTypes = config('cms.search.frontendSearchTypes');

        $sites = $this->site->get();

        $entries = [];
        $date = date('Y-m-d H:i:s');


        foreach($sites as $site) {
            Cms::setSite($site);

            if($site->publish_at < $date && (is_null($site->depublish_at) || $site->depublish_at > $date))
                $domain = Cms::site('protocol').Cms::site('domain');

                // start query
                $pages = $this->page;

                // attach the wanted builders
                foreach($searchTypes as $searchType) {
                    $pages = $pages->with(str_plural($searchType));
                }

                // get records
                $pages = $pages->get();

                // loop through all the pages
                foreach($pages as $page) {

                    if($page->publish_at < $date && (is_null($page->depublish_at) || $page->depublish_at > $date)) {
                        array_push($entries, [
                            'page_id' => $page->id,
                            'title' => $page->title,
                            'body' => Front::str_short(strip_tags($page->body)),
                            'url' => $domain.'/'.ltrim($page->prepend_slug.'/'.$page->slug, '/'),
                            'value' => strip_tags($page->body),
                            'search_priority' => $page->search_priority,
                            'publish_date' => $page->publish_at,
                            'created_at' => $date,
                            'updated_at' => $date,
                        ]);

                        // extract builders from page
                        foreach($searchTypes as $searchType) {
                            $builders = $page->{str_plural($searchType)};

                            // loop through builders
                            foreach($builders as $builder) {
                                array_push($entries, [
                                    'page_id' => $page->id,
                                    'title' => $page->title,
                                    'body' => Front::str_short(strip_tags($page->body)),
                                    'url' => $domain.'/'.ltrim($page->prepend_slug.'/'.$page->slug, '/'),
                                    'value' => strip_tags($builder->value),
                                    'search_priority' => $page->search_priority,
                                    'publish_date' => $page->publish_at,
                                    'created_at' => $date,
                                    'updated_at' => $date,
                                ]);
                            }
                        }
                    }
                }
            }
        }
        $this->searchIndex->truncate();
        $this->searchIndex->insert($entries);


        dd('dump');
        $q = $request->q;
    }
}
