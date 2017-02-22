<?php

namespace Thorazine\Hack\Http\Controllers\Cms\Email;

use Thorazine\Hack\Http\Requests\Email\ValidatePersistence;
use App\Http\Controllers\Controller;
use Thorazine\Hack\Models\Auth\CmsPersistence;
use Illuminate\Http\Request;
use Thorazine\Hack\Http\Requests;

class ValidateController extends Controller
{

	public function __construct(CmsPersistence $persistence)
	{
        $this->persistence = $persistence;
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
    		return view('cms.auth.validate-success');
    	}

    	abort(404, 'No validation found');
    }
}
