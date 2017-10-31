<?php

namespace Thorazine\Hack\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function index()
    {
    	return view('hack::settings.index');
    }
}
