<?php

namespace Thorazine\Hack\Facades;

use Illuminate\Support\Facades\Facade;

class HackFacade extends Facade {


    protected static function getFacadeAccessor()
    {
    	return 'hack';
    }
}
