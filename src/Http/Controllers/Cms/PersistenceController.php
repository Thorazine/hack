<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Models\Auth\CmsPersistence;

class PersistenceController extends CmsController
{

    public function __construct(CmsPersistence $model)
    {
        $this->model = $model;
        $this->slug = 'persistences';

        parent::__construct($this);

        view()->share([
            'extraHeaderButtons' => function($datas) {
                return [
                    [
                        'class' => 'primary',
                        'route' => route('cms.users.index'),
                        'text' => '<i class="fa fa-arrow-left"></i> '.trans('hack::cms.back'),
                    ],
                ];
            },
        ]);
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
        return $query;
    }
}
