<?php

namespace Thorazine\Hack\Http\Controllers;

use Thorazine\Hack\Http\Requests\ValidatePersistence;
use App\Http\Controllers\Controller;
use Thorazine\Hack\Models\Auth\HackPersistence;
use Illuminate\Http\Request;
use Sentinel;

class AuthController extends Controller
{

	public function __construct(HackPersistence $persistence)
	{
        $this->persistence = $persistence;
	}


    public function index()
    {
    	if(Sentinel::check()) {
            return redirect()->route('hack.overview.index');
        }
    	return view('hack::auth.index');
    }

    public function persistence()
    {
    	if(Sentinel::check()) {
            return redirect()->route('hack.overview.index');
        }
    	return view('hack::auth.persistence');
    }

    /**
	 * Validate a validation email
	 */
    public function validatePersistence(ValidatePersistence $request)
    {
    	$success = $this->persistence->where('verification_hash', $request->hash)->update([
    		'verified' => 1,
    		'updated_at' => date('Y-m-d H:i:s'),
    	]);

    	if($success) {
    		return redirect()->route('hack.overview.index');
    	}

    	abort(404, 'No validation found');
    }
}
