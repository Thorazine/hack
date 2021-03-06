<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Http\Requests\ModuleStore;
use Thorazine\Hack\Models\Menu;
use Cms;

class MenuController extends CmsController
{


    public function __construct(Menu $model)
    {
        $this->model = $model;
        $this->slug = 'menus';

        view()->share([
            'extraItemButtons' => function($data) {
                return [
                    [
                        'class' => 'primary',
                        'route' => route('cms.menu_items.index', (($data->id) ? ['fid' => $data->id] : [] )),
                        'text' => 'Edit',
                    ],
                ];
            },
            'extraEditButtons' => function($data) {
                return [
                    [
                        'class' => '',
                        'route' => route('cms.menu_items.index', ['fid' => $data['id']]),
                        'text' => '<i class="fa fa-bars"></i> '.trans('hack::cms.add'),
                    ]
                ];
            }
        ]);

        parent::__construct($this);
    }


    /**
     * Get the values for updating. This function
     * makes overwriting it with an array  
     * for the child class easier
     *
     * @param  \Illuminate\Http\Request  $request|array
     * @return \Illuminate\Http\Response|array
     */
    protected function beforeStore($request)
    {
        $this->extraCreateValues = [
            'site_id' => Cms::siteId(),
        ];

        return $request;
    }
}
