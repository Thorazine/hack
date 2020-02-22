<?php

namespace Thorazine\Hack\Http\Controllers\Cms\Auth;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use App\Http\Controllers\Controller;
use Thorazine\Hack\Models\Auth\CmsPersistence;
use Thorazine\Hack\Http\Requests\LoginRequest;
use Thorazine\Hack\Classes\Tools\Browser;
use Illuminate\Http\Request;
use Thorazine\Hack\Http\Requests;
use Thorazine\Hack\Models\DbLog;
use Carbon\Carbon;
use Validator;
use Exception;
use Location;
use Sentinel;
use Cms;
use Mail;

class AuthController extends Controller
{

    private $locationSession = null;


    public function __construct(Location $location, Browser $browser, CmsPersistence $persistence)
    {
        $this->browser = $browser;
        $this->location = $location;
        $this->persistence = $persistence;
    }


    /**
     * Show the login screen
     */
    public function index(Request $request)
    {
        if(Sentinel::check()) {
            return redirect()->route('cms.panel.index');
        }

        if($_SERVER['SERVER_NAME'] == 'localhost') {
            return view('hack::auth.index')
                ->with('latitude', '55')
                ->with('longitude', '5')
                ->with('locationPermission', 2)
                ->with('alertInfo', 'The Google systems don\'t work on localhost without a key. So a default location has been set.');
        }

        // pre define the response
        $response = response();

        $locationPermission = 0;
        if($request->cookie('location_permission')) {
            $locationPermission = $request->cookie('location_permission_set');
        }

        return view('hack::auth.index')
            ->with('locationPermission', $locationPermission);
    }


    /**
     * handle the login request
     */
    public function store(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        try {
            if($user = Sentinel::authenticateAndRemember($credentials)) {

                // make a request cache version of the user
                Cms::setUser($user);

                // convert the coordinates to a city and country
                $location = json_decode(file_get_contents('https://api.ipdata.co?api-key=be5013fcc732346e548c0e943a1446965c27f438ac0c10f9d6541314'));
                // $location = Location::locale('en')->coordinatesToAddress(['latitude' => $request->latitude, 'longitude' => $request->longitude])->get();
// dd($location);
                $active = $this->persistence->shouldBeActive($user->id, $location->latitude, $location->longitude);

                $hash = hash('sha256', microtime().rand().env('APP_KEY'));

                $persistenceAddData = $this->browser->os()
                        ->device()
                        ->deviceType()
                        ->browserAndVersion('browser')
                        ->get()+[
                    'site_id' => Cms::siteId(),
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'country' => $location->country_name,
                    'city' => $location->city,
                    'verified' => $active,
                    'verification_hash' => $hash,
                ];

                // get the persistance record for this session
                $persistence = $this->persistence
                    ->where('code', $request->session()->get(config('cartalyst.sentinel.session')))
                    ->where('user_id', $user->id)
                    ->update($persistenceAddData);

                // if we are in range or it is first run
                if($active) {
                    DbLog::add(__CLASS__, 'login', json_encode($request->except('password')));
                    return redirect()->route('cms.panel.index');
                }

                // email user for verification to confirm the location
                Mail::send('hack::emails.validate', ['user' => $user, 'persistence' => $persistenceAddData], function($message) use ($user) {
                    $message->to($user->email);
                    $message->subject('Hack CMS - Login attempt needs verification');
                });

                return redirect()->route('cms.auth.persistence');
            }
            $error = 'Wrong email address and/or password';
        }
        catch(NotActivatedException $e) {
            $error = 'You are not activated.';
        }
        catch (ThrottlingException $e) {
            $error = 'To many attempts. Please try again in '.Carbon::now()->diffInSeconds($e->getFree()).' seconds.';
        }

        // login failed
        return redirect()->back()
            ->withCookie(cookie()->forever('location_permission_set', 1))
            ->with('locationPermission', 1)
            ->withInput()
            ->with('alert-error', $error);
    }


    /**
     * Show the persitence failure screen
     */
    public function persistence()
    {
        return view('hack::auth.persistence');
    }


    /**
     * Resend the persistence email
     */
    public function resend(Request $request)
    {
        $user = Cms::user();

        if(! $user) {
            abort(404, 'Not logged in.');
        }

        // no more code
        if($code = Cms::code()) {

            // get the persistance record for this session
            $persistence = $this->persistence
                ->where('code', $code)
                ->where('user_id', $user->id)
                ->where('verified', 0)
                ->first();

            if(! $persistence) {
                abort(404, 'No persistence found.');
            }


            // email user for verification
            Mail::send('hack::emails.validate', ['user' => $user, 'persistence' => $persistence], function($message) use ($user) {
                $message->to($user->email);
                $message->subject('Hack CMS - Login attempt needs verification');
            });

            return view('hack::auth.resend');
        }
        // no more code in session, so login, get code
        return redirect()->route('cms.auth.index');
    }


    public function destroy()
    {
        DbLog::add(__CLASS__, 'logout', '');

        Sentinel::logout();

        return redirect()->route('cms.auth.index');
    }
}
