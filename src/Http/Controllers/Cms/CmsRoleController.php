<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Models\Auth\CmsRole;
use Cms;
use DB;

class CmsRoleController extends CmsController
{

    public function __construct(CmsRole $model)
    {
        $this->model = $model;
        $this->slug = 'roles';

        parent::__construct($this);
    }


    /**
     * Get the values for saving. This function
     * makes overwriting it with an array  
     * for the child class easier
     *
     * @param  \Illuminate\Http\Request  $request|array
     * @return \Illuminate\Http\Response|array
     */
    public function storeValues($request)
    {
        return [
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'permissions' => ($request->permissions) ? json_encode($request->permissions) : null,
        ];
    }


    /**
     * Get the values for saving. This function
     * makes overwriting it with an array  
     * for the child class easier
     *
     * @param  \Illuminate\Http\Request  $request|array
     * @param  int  $id
     * @return \Illuminate\Http\Response|array
     */
    public function updateValues($request, $id)
    {
        return [
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'permissions' => ($request->permissions) ? json_encode($request->permissions) : null,
        ];
    }
}