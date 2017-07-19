<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Models\Carousel;
use Cms;

class CarouselController extends CmsController
{

    public function __construct(Carousel $model)
    {
        $this->model = $model;
        $this->slug = 'carousels';

        parent::__construct($this);
    }


    /**
     * Give a chance to overwrite the 
     * view variables
     */
    public function afterViewInitialiser()
    {
        view()->share([
            'extraItemButtons' => function($data) {
                return [
                    [
                        'class' => 'primary',
                        'route' => route('cms.carousel_images.index', (($data->id) ? ['fid' => $data->id] : [] )),
                        'text' => trans('hack::modules.carousels.slides'),
                    ],
                ];
            },
            'extraEditButtons' => function($data) {
                return [
                    [
                        'class' => '',
                        'route' => route('cms.carousel_images.index', ['fid' => $data['id']]),
                        'text' => '<i class="fa fa-bars"></i> '.trans('hack::cms.add'),
                    ]
                ];
            }
        ]);
    }


    /**
     * Get the values for saving. This function
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
