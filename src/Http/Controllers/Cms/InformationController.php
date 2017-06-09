<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Scopes\SiteScope;
use Thorazine\Hack\Models\Information;

class InformationController extends CmsController
{

    public function __construct(Information $model)
    {
        $this->model = $model;
        $this->slug = 'information';

        parent::__construct($this);
    }
}
