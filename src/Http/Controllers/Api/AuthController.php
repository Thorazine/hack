<?php

namespace Thorazine\Hack\Http\Controllers\Api;

use Thorazine\Hack\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function authenticate(AuthRequest $request)
    {
    	return response()->json([

    	], 200);
    }
}
