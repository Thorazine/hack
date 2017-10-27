<?php

namespace Thorazine\Hack\Http\Controllers\Api;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Thorazine\Hack\Http\Requests\ValidatePersistence;
use Thorazine\Hack\Models\Auth\HackPersistence;
use Thorazine\Hack\Http\Requests\AuthRequest;
use Thorazine\Hack\Classes\Tools\Browser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Sentinel;
use Thorazine\Hack\Models\DbLog;
use Mail;
use Hack;
use Location;
use Carbon\Carbon;

class AuthController extends Controller
{

	public function __construct(Location $location, Browser $browser, HackPersistence $persistence)
    {
        $this->browser = $browser;
        $this->location = $location;
        $this->persistence = $persistence;
    }

    public function authenticate(AuthRequest $request)
    {
    	$credentials = $request->only('email', 'password');

    	try {
            if($user = Sentinel::authenticateAndRemember($credentials)) {

                // make a request cache version of the user
                Hack::setUser($user);

                // convert the coordinates to a city and country
                $location = Location::locale('en')->coordinatesToAddress(['latitude' => $request->latitude, 'longitude' => $request->longitude])->get();

                // check if the location is active
                $active = $this->persistence->shouldBeActive($user->id, $request->latitude, $request->longitude);

                $persistenceAddData = $this->browser->os()
                        ->device()
                        ->deviceType()
                        ->browserAndVersion('browser')
                        ->get()+[
                    'site_id' => Hack::siteId(),
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'country' => $location['country'],
                    'city' => $location['city'],
                    'verified' => $active,
                    'verification_hash' => $this->generateHash(),
                ];

                // get the persistance record for this session
                $persistence = $this->persistence
                    ->where('code', $request->session()->get(config('cartalyst.sentinel.session')))
                    ->where('user_id', $user->id)
                    ->update($persistenceAddData);

                // if we are in range or it is first run
                if($active) {
                    DbLog::add(__CLASS__, 'login', json_encode($request->except('password')));
                    return response()->json([
	            		'url' => route('hack.overview.index'),
			    	], 200);
                }

                $this->sendPersistanceMail($user, $persistenceAddData);

                return response()->json([
            		'url' => route('hack.overview.index'),
		    	], 200);
            }

            $error = 'Wrong email address and/or password';
        }
        catch(NotActivatedException $e) {
            $error = 'You are not activated.';
        }
        catch (ThrottlingException $e) {
            $error = 'To many attempts. Please try again in '.Carbon::now()->diffInSeconds($e->getFree()).' seconds.';
        }

        return response()->json([
    		'message' => $error,
    	], 422);
    }

    /**
     * Resend the persistence email
     */
    public function resend(Request $request)
    {
        $user = Hack::user();

        if(! $user) {
            abort(404, 'Not logged in.');
        }

        // no more code
        if($code = Hack::code()) {

            // get the persistance record for this session
            $persistence = $this->persistence
                ->where('code', $code)
                ->where('user_id', $user->id)
                ->where('verified', 0)
                ->first();

            if(! $persistence) {
                abort(404, 'No persistence found.');
            }

            $this->sendPersistanceMail($user, $persistence);

            return response()->json([
            	'success' => true,
            ], 200);
        }
        // no more code in session, so login, get code
        return response()->json([
        	'url' => route('hack.auth.index'),
        ], 200);
    }

    /**
	 * Generate a naice and random hash for persistence acceptance.
	 */
    private function generateHash()
    {
    	return hash('sha256', microtime().rand().env('APP_KEY'));
    }

    /**
     * Send the persistance mail
     */
    private function sendPersistanceMail($user, $persistence)
    {
    	// email user for verification
        Mail::send('hack::emails.validate', ['user' => $user, 'persistence' => $persistence], function($message) use ($user) {
            $message->to($user->email);
            $message->subject('Hack - Login attempt needs verification');
        });
    }
}
