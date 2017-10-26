<?php

namespace Thorazine\Hack\Models\Auth;

use Cartalyst\Sentinel\Roles\EloquentRole;
use Thorazine\Hack\Models\Site;
use Sentinel;
use Hack;

class HackRole extends EloquentRole
{
	/**
	 * Overwrite the sentinel default table with a new
	 * one so we can keep using the roles for in site
	 *
	 **/
	protected $table = 'hack_roles';


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
            'name' => [
                'type' => 'text',
                'label' => trans('hack::modules.roles.name'),
                'regex' => 'required',
            ],
            'permissions' => [
                'type' => 'permissions',
                'label' => trans('hack::modules.roles.permissions'),
                'regex' => '',
                'values' => 'getRights',
                'overview' => false,
            ],
        ];
    }


    public function getRights()
    {
        return config('rights');
    }


    public function getPermissionsAttribute($value)
    {
        if($permissions = json_decode($value)) {
            return $permissions;
        }
        return [];
    }

}
