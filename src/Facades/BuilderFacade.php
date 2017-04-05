<?php

namespace Thorazine\Hack\Facades;

use Illuminate\Support\Facades\Facade;

class BuilderFacade extends Facade {


    protected static function getFacadeAccessor() 
    { 
    	return 'builder'; 
    }
}