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
    }
}
