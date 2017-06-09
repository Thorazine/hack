<?php

namespace Thorazine\Hack\Models;

use Illuminate\Database\Eloquent\Model;
use Thorazine\Hack\Scopes\SiteScope;
use Thorazine\Hack\Models\Site;

class Information extends CmsModel
{	
	/**
	 * Overwrite the sentinel default table with a new 
	 * one so we can keep using the users for in site
	 *
	 **/
	protected $table = 'information';


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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SiteScope);
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
            'message_type' => [
                'type' => 'select',
                'label' => trans('modules.information.message_type'),
                'regex' => '',
                'values' => [
                    'maintenance' => trans('modules.information.maintenance'),
                    'news' => trans('modules.information.news'),
                ],
            ],
            'image' => [
                'type' => 'image',
                'label' => trans('modules.information.image'),
                'regex' => '',
                'width' => 1024,
                'height' => 576,
                'overview' => false,
            ],
            'title' => [
                'type' => 'text',
                'label' => trans('modules.information.title'),
                'regex' => '',
            ],
            'message' => [
                'type' => 'wysiwyg',
                'label' => trans('modules.information.message'),
                'regex' => '',
                'configuration' => 'full',
                'overview' => false,
            ],
            'start_date' => [
                'type' => 'timestamp',
                'label' => trans('modules.information.start_date'),
                'regex' => '',
                'default' => date('Y-m-d H:i:s'),
                'position' => 'sidebar',
            ],
            'end_date' => [
                'type' => 'timestamp',
                'label' => trans('modules.information.end_date'),
                'regex' => '',
                'position' => 'sidebar',
                'overview' => false,
            ],
            'publish_at' => [
                'type' => 'timestamp',
                'label' => trans('modules.information.publish_at'),
                'regex' => '',
                'default' => date('Y-m-d H:i:s'),
                'position' => 'sidebar',
                'overview' => false,
            ],
            'depublish_at' => [
                'type' => 'timestamp',
                'label' => trans('modules.information.depublish_at'),
                'regex' => '',
                'position' => 'sidebar',
                'overview' => false,
            ],
        ];
    } 

}
