<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Models\NotFound;

class NotFoundController extends CmsController
{

    public function __construct(NotFound $model)
    {
        $this->model = $model;
        $this->slug = 'not_found';

        parent::__construct($this);
    }
}
