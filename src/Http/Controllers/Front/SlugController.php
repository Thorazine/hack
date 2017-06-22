<?php

namespace Thorazine\Hack\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Thorazine\Hack\Classes\PageOutput;
use Thorazine\Hack\Models\Pageable;
use Thorazine\Hack\Http\Requests;
use Thorazine\Hack\Models\Page;
use Thorazine\Hack\Models\Site;
use Thorazine\Hack\Models\Slug;
// use Builder;
use Cache;
use Cms;
use View;
use Log;
use DB;

class SlugController extends Controller
{
    

    public function __construct(Page $page, Slug $slug, Pageable $pageable, PageOutput $pageOutput)
    {
    	$this->page = $page;
        $this->slug = $slug;
    	$this->pageable = $pageable;
        $this->pageOutput = $pageOutput;
    }


    public function slug(Request $request)
    {   
        // See if the site in all should be online
        if(! Cms::site('publish_at') || (Cms::site('publish_at') < date('Y-m-d H:i:s') && (Cms::site('depublish_at') && date('Y-m-d H:i:s') > Cms::site('depublish_at')))) {
            return view('offline');
        }

    	$page = Cache::tags('pages', 'templates', 'slugs')->remember(Cms::cacheKey(['page', $request->slug, Cms::siteId()]), env('PAGE_CACHE_TIME', 1), function() use ($request) {
            return $this->pageOutput->bySlug($request->slug);
	    });

        // if we get an array with an abort for page, we need to redirect
        if(is_array($page) && array_key_exists('abort', $page)) {
            $this->abort($page['abort'], @$page['attribute']);
        }

        // Counteract high cache times. Check to see if we should be online
        if(! $page['publish_at'] || ($page['publish_at'] < date('Y-m-d H:i:s') && ($page['depublish_at'] && date('Y-m-d H:i:s') > $page['depublish_at']))) {
            $this->abort(404);
        }

        $response = view($this->getView($page))
            ->with('page', $page);

	    return response($response)
            ->header('Cache-Control', 'public, max-age='.Cms::site('browser_cache_time'))
            ->header('Expires', date('D, d M Y H:i:s ', time() + Cms::site('browser_cache_time')).'GMT');
    }


    /**
     * Create a cache key from an array
     * 
     * @param Collection $page
     * @return string|abort
     */
    private function getView($page)
    {
        if(View::exists($page['site_id'].'.'.$page['view'])) {
            return $page['site_id'].'.'.$page['view'];
        }

        // log the error
        Log::error('View '.$page['site_id'].'.'.$page['view'].' not found', [
            'view' => $page['site_id'].'.'.$page['view'],
            'data' => $page,
        ]);

        if(in_array($page->slug, [404, 500])) {
            die('You have not created a "resources.views.'.$page['site_id'].'.'.$page['view'].'" view that you defined for the '.$page->slug.'!<br><br>Please fix this to prevent a loop.');
        }

        // abort to 404
        $this->abort(404, 'View '.$page['site_id'].'.'.$page['view'].' not found');
    }


    /**
     * Handle the aborts
     *
     * @param int $code
     * @param array $attributes
     * @return void
     */
    public function abort($code, $attribute = null)
    {
        switch ($code) {
            case 404:
                abort(404, $attribute);
                break;
            
            case 301:
                if(! $attribute) {
                    $this->abort(404, null);
                }
                header("HTTP/1.1 301 Moved Permanently");
                header('Location: '.$attribute);
                die();
                break;

            default:
                abort(404);
        }
        
    }
}
