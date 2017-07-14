<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Scopes\SiteScope;
use Thorazine\Hack\Models\DbLog;

class DbLogController extends CmsController
{

    public function __construct(DbLog $model)
    {
        $this->model = $model;
        $this->slug = 'db_logs';

        parent::__construct($this);

        view()->share([
            'filters' => [
                'action' => [
                    'type' => 'select',
                    'values' => function() {
                        return ['' => '-- '.trans('hack::modules.db_logs.action').' --']+
                        	$this->model
	                            ->groupBy('action')
	                            ->pluck('action', 'action')
	                            ->toArray();
                    },
                ],
                'level' => [
                    'type' => 'select',
                    'values' => function() {
                        return [
                        	'' => '-- '.trans('hack::modules.db_logs.level').' --',
                        	1 => '1',
                        	2 => '2',
                        	3 => '3',
                        ];
                    },
                ]
            ],
        ]);
    }


    /**
     * Add the default order to the model. If "hasOrder" 
     * That will take default
     *
     * @param  string  $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function defaultOrder($query)
    {
        return $query->orderBy('id', 'desc');
    }
}
