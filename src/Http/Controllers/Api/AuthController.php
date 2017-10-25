<?php

namespace Thorazine\Hack\Http\Controllers\Api;

use Thorazine\Hack\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Sentinel;

class AuthController extends Controller
{
    public function authenticate(AuthRequest $request)
    {
    	$credentials = $request->only('email', 'password');

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
