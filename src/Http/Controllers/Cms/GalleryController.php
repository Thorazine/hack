<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Models\Gallery;

class GalleryController extends CmsController
{

    public function __construct(Gallery $model)
    {
        $this->model = $model;
        $this->slug = 'gallery';

        parent::__construct($this);
    }


    /**
     * Before the delete action takes place
     *
     * @param  integer  $id
     */
    public function beforeDelete($id)
    {
        // Remove the image before the record
        $gallery = $this->model->find($id);

        $gallery->remove(true); // remove the gallery with it's images
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
        return $query->where('parent_id', null);
    }
}
