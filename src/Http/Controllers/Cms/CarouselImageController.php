<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

// use Thorazine\Hack\Http\Requests\ModuleStore;
// use Illuminate\Http\Request;
use Thorazine\Hack\Models\CarouselImage;
use Thorazine\Hack\Models\Carousel;
use Cms;

class CarouselImageController extends CmsController
{


    public function __construct(CarouselImage $model)
    {
        $this->model = $model;
        $this->slug = 'carousel_images';
        $this->hasOrder = true;

        parent::__construct($this);

        view()->share([
            'extraHeaderButtons' => function($datas) {
                return [
                    [
                        'class' => 'primary',
                        'route' => route('cms.carousels.index'),
                        'text' => '<i class="fa fa-arrow-left"></i> '.trans('hack::cms.back'),
                    ],
                ];
            },
        ]);
    }


    /**
     * An easy way to break in to the 
     * create proces before sending
     * it out to the view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Collection  $data
     * @return mixed
     */
    protected function beforeCreateExtra($request, $data)
    {
        $carousel = Carousel::find($request->fid);

        $this->model->types['image']['width'] = $carousel->width;
        $this->model->types['image']['height'] = $carousel->height;

        view()->share([
            'types' => $this->model->types,
        ]);

        return $data;
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
            'carousel_id' => $request->fid,
        ];
        
        return $request;
    }

    /**
     * An easy way to break in to the 
     * edit proces before sending
     * it out to the view without changing the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  Collection  $data
     * @return mixed
     */
    protected function beforeEditExtra($request, $id, $data)
    {
        $carousel = Carousel::find($data['carousel_id']);

        $this->model->types['image']['width'] = $carousel->width;
        $this->model->types['image']['height'] = $carousel->height;

        view()->share([
            'types' => $this->model->types,
        ]);

        return $data;
    }


    /**
     * Before the delete action takes place
     *
     * @param  integer  $id
     */
    public function beforeDelete($id)
    {
        // Remove the image before the record
        $carouselImage = $this->model->with('gallery')->find($id);

        $carouselImage->gallery->remove(); // remove the gallery with it's images
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
        if($request->fid) {
            return $query->with('gallery')->where('carousel_id', $request->fid);
        }
        return $query->with('gallery');
    }
}
