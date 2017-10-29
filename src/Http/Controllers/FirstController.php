<?php

namespace Thorazine\Hack\Http\Controllers;

use App\Http\Controllers\Controller;
use Thorazine\Hack\Models\Site;
use Illuminate\Http\Request;

class FirstController extends Controller
{
	public function __construct(Site $site)
    {
    	$this->site = $site;
    }

    public function index()
    {
    	if(! $this->site->count()) {
    		return view('hack::first.index');
    	}
        return redirect()->route('hack.auth.index');
    }
}
