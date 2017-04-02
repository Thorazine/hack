<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Models\Slug;

class SlugController extends CmsController
{

    public function __construct(Slug $model)
    {
        $this->model = $model;
        $this->slug = 'slugs';

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
        return $query->with('page');
    }
}
