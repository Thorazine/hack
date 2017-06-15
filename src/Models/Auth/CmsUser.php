<?php

namespace Thorazine\Hack\Models\Auth;

use Illuminate\Database\Eloquent\SoftDeletes;
use Cartalyst\Sentinel\Users\EloquentUser;
use Thorazine\Hack\Models\Auth\CmsRole;

class CmsUser extends EloquentUser
{
    use SoftDeletes;
    
    /**
     * Overwrite the sentinel default table with a new 
     * one so we can keep using the users for in site
     *
     **/
    protected $table = 'cms_users';


    /**
     * Placeholder for types.
     */
    public $types = [];


    /**
     * Constructor
     */
    public function __construct()
    {
        // we need to force the parent construct
        parent::__construct();

        $this->types = $this->types();
    }


    /**
     * Return all the types for this module
     */
    public function types()
    {
        return [
            'id' => [
                'type' => 'number',
                'label' => 'Id',
                'regex' => '',
                'overview' => false,
                'create' => false,
                'edit' => false,
            ],
            'email' => [
                'type' => 'text',
                'label' => trans('modules.users.email'),
                'regex' => 'required',
            ],
            'password' => [
                'type' => 'password',
                'label' => trans('modules.users.password'),
                'confirmation_label' => 'Confirm password',
                'regex' => [
                    'create' => [
                        'required',
                    ],
                    'edit' => [
                        'confirmed',
                    ],
                ],
                'overview' => false,
                'edit' => false,
            ],
            'language' => [
                'type' => 'select',
                'label' => trans('modules.users.language'),
                'regex' => '',
                'values' => config('cms.cms-languages'),
            ],
            'image' => [
                'type' => 'image',
                'label' => trans('modules.users.image'),
                'regex' => '',
                'width' => 240,
                'height' => 240,
            ],
            'first_name' => [
                'type' => 'text',
                'label' => trans('modules.users.first_name'),
                'regex' => '',
            ],
            'last_name' => [
                'type' => 'text',
                'label' => trans('modules.users.last_name'),
                'regex' => '',
            ],
            'roles' => [
                'type' => 'multi-checkbox',
                'label' => trans('modules.users.roles'),
                'regex' => '',
                'values' => 'getRoles',
                'overview' => false,
                'labelField' => 'name',
                'valueField' => 'id',
            ],
            'permissions' => [
                'type' => 'permissions',
                'label' => trans('modules.users.permissions'),
                'regex' => '',
                'values' => config('rights'),
                'overview' => false,
            ],
        ];
    } 


    public function gallery()
    {
        return $this->hasOne('Thorazine\Hack\Models\Gallery', 'id', 'image');
    }


    /**
     * Get all the availible roles
     */
    public function getRoles($data = [], $key = '')
    {
        if(! @$this->cmsRoles) {
           $this->cmsRoles = CmsRole::select('id', 'name')->orderBy('name', 'asc')->pluck('name', 'id');
        }
        return $this->cmsRoles;
    }


}