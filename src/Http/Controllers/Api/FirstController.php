<?php

namespace Thorazine\Hack\Http\Controllers\Api;

use Thorazine\Hack\Http\Requests\FirstRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Thorazine\Hack\Models\Auth\HackRole;
use Thorazine\Hack\Models\Site;
use Thorazine\Hack\Models\DbLog;
use Exception;
use Sentinel;
use Log;
use DB;

class FirstController extends Controller
{

	public function __construct(Site $site)
    {
    	$this->site = $site;
    }


    public function store(FirstRequest $request)
    {
        try {
        	DB::beginTransaction();

            if(! $this->site->count()) {

            	$site = new $this->site;
            	$site->domain = $request->domain;
            	$site->protocol = $request->protocol;
            	$site->language = $request->language;
            	$site->languages = $request->language;
            	$site->title = $request->title;
            	$site->publish_at = date('Y-m-d H:i:s');
            	$site->save();

            	// get all possible rights
                $rights = $this->getAllRightsAsArray();

                // create the administrator role
                $cmsRole = new HackRole;
                $cmsRole->name = 'Administrators';
                $cmsRole->slug = 'administrators';
                $cmsRole->permissions = $rights;
                $cmsRole->save();

                $clientRights = array_except($rights, [
                    'templates',
                    'users',
                    'roles',
                    'settings',
                    'information',
                    'logs',
                ]);

                $cmsRole = new HackRole;
                $cmsRole->name = 'Clients';
                $cmsRole->slug = 'clients';
                $cmsRole->permissions = $clientRights;
                $cmsRole->save();

                // get the role
                $role = Sentinel::findRoleBySlug('administrators');

                // create the user
                $user = Sentinel::registerAndActivate([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email'    => $request->email,
                    'password' => $request->password,
                ]);

                // attach the user to the role
                $role->users()->attach($user);

                DB::commit();

                DbLog::add(__CLASS__, 'create', 'Congratulations! You have successfully created Hack!');

                return response()->json([
            		'url' => route('hack.overview.index'),
		    	], 200);
            }
            else {
            	return response()->json([
            		'message' => 'First site already exists. Go away.',
		    	], 422);
            }
        }
        catch(Exception $e) {
        	DB::rollBack();

            Log::error('Rollback after trying to create a site.', [
                'data' => $request->all(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
        		'message' => $e->getMessage(),
	    	], 422);
        }
    }

    /**
     * Get all availible rights in an array
     */
    private function getAllRightsAsArray()
    {
        $sites = Site::select('id', 'title')
            ->orderBy('title', 'asc')
            ->get();

        $return = [];

        foreach($sites as $site) {
            foreach(config('rights') as $type => $rights) {
                foreach($rights as $right) {
                    array_push($return, $site->id.'.cms.'.$type.'.'.$right);
                }
            }
        }

        return $return;
    }
}
