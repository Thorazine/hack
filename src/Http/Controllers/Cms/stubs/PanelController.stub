<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Thorazine\Hack\Http\Requests;
use Thorazine\Hack\Models\Information;

class PanelController extends Controller
{
    
    public function __construct()
    {

    }


    public function index()
    {    	
    	$maintenance = Information::published()
    		->where('message_type', 'maintenance')
    		->first();

    	return view('hack::panel')
    		->with('maintenance', $maintenance);
    }
}
