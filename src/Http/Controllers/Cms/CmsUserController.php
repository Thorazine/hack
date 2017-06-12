<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Models\Auth\CmsUser;
use Hash;
use DB;

class CmsUserController extends CmsController
{

    public function __construct(CmsUser $model)
    {
        $this->model = $model;
        $this->slug = 'users';

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
    protected function storeValues($request)
    {
        return $request->except('permissions', 'roles', 'password', 'password_confirmation')+[
            'permissions' => ($request->permissions) ? json_encode($request->permissions) : null,
            'password' => Hash::make($request->password),
        ];
    }


    public function storeExtra($request, $id)
    {
        // get all the current role id for this user
        $roleIds = DB::table('role_users')
            ->where('user_id', $id)
            ->pluck('role_id')
            ->toArray();

        $roles = ($request->roles) ? $request->roles : [];

        foreach($roles as $role) {
            if(in_array($role, $roleIds)) {
                // remove item from list, no update needed
                if(($key = array_search($role, $roleIds)) !== false) {
                    unset($roleIds[$key]);
                }
            }
            else {
                // add item
                DB::table('role_users')
                    ->insert([
                        'user_id' => $id,
                        'role_id' => $role,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
            }
        }

        DB::table('role_users')->where('user_id', $id)->whereIn('role_id', $roleIds)->delete();
    }


    public function editExtra($request, $id, $data)
    {
        $data['roles'] = (@$data['roles']) ? collect($data['roles'])->pluck('id')->all() : [];

        return view('cms.models.edit')
            ->with('data', $data)
            ->with('id', $id);
    }


    public function updateValues($request, $id)
    {
        return $request->except('roles', 'permissions', 'password', 'password_confirmation')+[
            'permissions' => ($request->permissions) ? json_encode($request->permissions) : null,
        ]+(($request->password) ? ['password' => Hash::make($request->password)] : []);
    }


    public function updateExtra($request, $id)
    {
        // get all the current role id for this user
        $roleIds = DB::table('role_users')
            ->where('user_id', $id)
            ->pluck('role_id')
            ->toArray();

        $roles = ($request->roles) ? $request->roles : [];

        foreach($roles as $role) {
            if(in_array($role, $roleIds)) {
                // remove item from list, no update needed
                if(($key = array_search($role, $roleIds)) !== false) {
                    unset($roleIds[$key]);
                }
            }
            else {
                // add item
                DB::table('role_users')
                    ->insert([
                        'user_id' => $id,
                        'role_id' => $role,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
            }
        }

        DB::table('role_users')->where('user_id', $id)->whereIn('role_id', $roleIds)->delete();
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
        return $query->with('roles')->with('gallery');
    }
}