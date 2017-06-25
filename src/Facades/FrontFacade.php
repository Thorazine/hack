<?php

namespace Thorazine\Hack\Facades;

use Illuminate\Support\Facades\Facade;

class FrontFacade extends Facade {


    protected static function getFacadeAccessor() 
    { 
    	return 'front'; 
    }
}