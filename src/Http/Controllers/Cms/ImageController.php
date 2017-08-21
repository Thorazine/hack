<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Models\Slug;

class ImageController extends CmsController
{

    public function __construct(Slug $model)
    {
        $this->model = $model;
        $this->slug = 'images';

        parent::__construct($this);
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
