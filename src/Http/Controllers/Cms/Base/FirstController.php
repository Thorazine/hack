<?php

namespace Thorazine\Hack\Http\Controllers\Cms\Base;

use Thorazine\Hack\Http\Requests\BaseFirstRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Thorazine\Hack\Models\Auth\CmsRole;
use Thorazine\Hack\Http\Requests;
use Thorazine\Hack\Models\Site;
use Thorazine\Hack\Models\DbLog;
use Sentinel;
use DB;

class FirstController extends Controller
{
    public function __construct(Site $site)
    {
    	$this->site = $site;
    }


    /**
     *
     */
    public function index()
    {

        if(! $this->site->count()) {
    		return view('cms.base.first');
    	}
    }


    /**
     *
     */
    public function store(BaseFirstRequest $request)
    {
        try {
            DB::beginTransaction();

            if(! $this->site->count()) {

                // create the first site
                $siteId = $this->site->insertGetId([
                    'domain' => str_replace(['http://', 'https://'], ['', ''], $request->domain), // copy paste is an easy mistake
                    'protocol' => $request->protocol,
                    'language' => $request->language,
                    'languages' => $request->language,
                    'title' => $request->title,
                    'publish_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                $rights = $this->getAllRightsAsArray();

                // create the administrator role
                CmsRole::insert([
                    'name' => 'Administrators',
                    'slug' => 'administrators',
                    'permissions' => json_encode($rights),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                $clientRights = array_except($rights, [
                    'templates',
                    'users',
                    'roles',
                    'settings',
                    'information',
                    'logs',
                ]);

                // create the client role
                CmsRole::insert([
                    'name' => 'Clients',
                    'slug' => 'clients',
                    'permissions' => json_encode($clientRights),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

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

                return redirect()->route('cms.base.first.success');
            }

            return redirect()->route('cms.auth.index');

        }
        catch(Exception $e) {
            DB::rollBack();

            Log::error('Rollback after trying to create a site.', [
                'data' => $request->all(),
                'error' => $e->getMessage(),
            ]);

            return abort(500, 'There was an error. Not the best start...');
        }
    }


    /**
     *
     */
    public function success()
    {
        return view('cms.base.thank');
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
