<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Models\Auth\CmsRole;
use Thorazine\Hack\Models\Site;
use Cms;

class SiteController extends CmsController
{

    public function __construct(Site $model)
    {
        $this->model = $model;
        $this->slug = 'sites';

        parent::__construct($this);
    }


    public function storeExtra($request, $id)
    {
    	// get all the permissions and add them to administrator
    	CmsRole::where('slug', 'administrators')->update([
    		'permissions' => json_encode($this->getAllRights()),
    		'updated_at' => date('Y-m-d H:i:s'),
    	]);

    }


    private function getAllRights()
    {
    	$sites = $this->model->select('id', 'title')
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


    /**
     * Possibly add query parameters to the model
     *
     * @param  string  $query
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function queryParameters($query, $request)
    {
        return $query->whereIn('id', Cms::sitePermission($this->slug));
    }
}
