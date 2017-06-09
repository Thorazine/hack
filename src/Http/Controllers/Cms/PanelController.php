<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Thorazine\Hack\Http\Requests;

class PanelController extends Controller
{
    
    public function __construct()
    {

    }


    public function index()
    {    	
    	return view('cms.panel');
    }
}
