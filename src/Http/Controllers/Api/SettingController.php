<?php

namespace Thorazine\Hack\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Artisan;
use Cache;

class SettingController extends Controller
{

	public function __construct(Site $site)
    {
    	$this->site = $site;
    }


    public function cache(Request $request)
    {
    	Cache::flush();

    	return response()->json([
    		'message' => 'Cache cleared',
    	], 200);
    }


    public function search(Request $request)
    {
    	$exitCode = Artisan::call('hack:search');

    	return response()->json([
    		'message' => 'Search index complete',
    		'exitCode' => $exitCode,
    	], 200);
    }


    public function update(Request $request)
    {

    }
}
