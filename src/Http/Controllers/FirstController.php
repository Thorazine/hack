<?php

namespace Thorazine\Hack\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FirstController extends Controller
{
    public function index()
    {
    	return view('hack::first.index');
    }
}
