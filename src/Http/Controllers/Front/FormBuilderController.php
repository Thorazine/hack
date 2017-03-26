<?php

namespace Thorazine\Hack\Http\Controllers\Front;

use Thorazine\Hack\Http\Requests\FormBuilderStore;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormBuilderController extends Controller
{
    

    public function __construct()
    {
    	
    }


    public function store(FormBuilderStore $request)
    {
        return redirect()->back();
    }
}
