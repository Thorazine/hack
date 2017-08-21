<?php

namespace Thorazine\Hack\Facades;

use Illuminate\Support\Facades\Facade;

class CmsFacade extends Facade {


    protected static function getFacadeAccessor() 
    { 
    	return 'cms'; 
    }
}