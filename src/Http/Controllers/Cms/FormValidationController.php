<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Models\FormValidation;

class FormValidationController extends CmsController
{

    public function __construct(FormValidation $model)
    {
        $this->model = $model;
        $this->slug = 'form_validations';

        parent::__construct($this);
    }
}
