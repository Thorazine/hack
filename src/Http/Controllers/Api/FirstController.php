<?php

namespace Thorazine\Hack\Http\Controllers\Api;

use Thorazine\Hack\Http\Requests\FirstRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class FirstController extends Controller
{
    public function store(FirstRequest $request)
    {
        try {
            if($user = Sentinel::authenticateAndRemember($credentials)) {
            	return response()->json([
            		'url' => route('hack.base.index'),
		    	], 200);
            }
            else {
            	return response()->json([
            		'message' => 'Invalid authentication data',
		    	], 422);
            }
        }
        catch(Exception $e) {

        }
    }
}
