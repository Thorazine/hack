<?php

namespace Thorazine\Hack\Models;

use Illuminate\Database\Eloquent\Model;
use Thorazine\Hack\Models\Auth\HackUser;
use Thorazine\Hack\Scopes\SiteScope;
use Exception;
use Hack;
use Log;

class DbLog extends HackModel
{
	/**
	 * Overwrite the sentinel default table with a new
	 * one so we can keep using the users for in site
	 *
	 **/
	protected $table = 'logs';


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
            'cms_user_id' => [
            	'type' => 'select',
                'label' => trans('hack::modules.db_logs.cms_user_id'),
                'regex' => '',
                'values' => 'getHackUsers',
            ],
            'action' => [
                'type' => 'text',
                'label' => trans('hack::modules.db_logs.action'),
                'regex' => '',
            ],
            'level' => [
                'type' => 'text',
                'label' => trans('hack::modules.db_logs.level'),
                'regex' => '',
            ],
            'controller' => [
                'type' => 'text',
                'label' => trans('hack::modules.db_logs.controller'),
                'regex' => '',
            ],
            'request_data' => [
                'type' => 'label',
                'label' => trans('hack::modules.db_logs.request_data'),
                'regex' => '',
                // 'create' => false,
                // 'edit' => false,
                'overview' => false,
            ],
            'created_at' => [
                'type' => 'timestamp',
                'label' => trans('hack::modules.db_logs.created_at'),
                'regex' => '',
                'position' => 'sidebar',
                'create' => false,
                'edit' => false,
            ],
        ];
    }


    public function getHackUsers()
    {
    	return HackUser::select('id', 'email')->orderBy('email', 'asc')->pluck('email', 'id');
    }


	public static function add($namespace, $action, $request, $level = 1)
	{
		try {
			DbLog::insert([
				'site_id' => Hack::site('id'),
				'cms_user_id' => Hack::user('id'),
				'logged_session_id' => '',
				'level' => $level,
				'action' => $action,
				'controller' => $namespace,
				'request_data' => json_encode($request),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			]);
		}
		catch(Exception $e) {
			Log::error('Could not save to logs', [
                'error' => $e->getMessage(),
                'action' => $action,
                'namespace' => $namespace,
                'request' => $request,
            ]);
		}
	}

}
