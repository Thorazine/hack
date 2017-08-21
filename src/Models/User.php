<?php

namespace Thorazine\Hack\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends CmsModel
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
        parent::__construct($this);

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
            'image' => [
                'type' => 'image',
                'label' => trans('hack::modules.users.image'),
                'regex' => '',
                'width' => 240,
                'height' => 240,
            ],
            'email' => [
                'type' => 'text',
                'label' => trans('hack::modules.users.email'),
                'regex' => 'required',
            ],
            'first_name' => [
                'type' => 'text',
                'label' => trans('hack::modules.users.first_name'),
                'regex' => '',
            ],
            'last_name' => [
                'type' => 'text',
                'label' => trans('hack::modules.users.last_name'),
                'regex' => '',
            ],
            'language' => [
                'type' => 'select',
                'label' => trans('hack::modules.users.language'),
                'regex' => '',
                'values' => config('cms.cms-languages'),
            ],
            'password' => [
                'type' => 'password',
                'label' => trans('hack::modules.users.password'),
                'regex' => 'confirmed',
                'placeholder' => trans('hack::modules.users.password_placeholder'),
                'confirmation_label' => 'Password again',
                'confirmation_placeholder' => trans('hack::modules.users.password_confirm'),
            ],
        ];
    } 


    public function gallery()
    {
        return $this->hasOne('Thorazine\Hack\Models\Gallery', 'id', 'image');
    }


    public function persistences()
    {
        return $this->hasMany('Thorazine\Hack\Models\Auth\CmsPersistence');
    }


}