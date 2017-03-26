<?php

namespace Thorazine\Hack\Models\Builders;

use Illuminate\Database\Eloquent\Model;
use Thorazine\Hack\Models\Form as FormModel;

class Form extends BaseBuilder
{

    /**
     * The databae table
     */
    protected $table = 'builder_forms';

    /**
     * Set the type
     */
    public $type = 'form';


    /**
     * Constructor
     */
    public function __construct()
    {
        // we need to force the parent construct
        parent::__construct($this);
    }


    /**
     * 
     */
    public function form()
    {
        return $this->hasOne('Thorazine\Hack\Models\Form', 'id', 'value');
    }


    /**
     * Add to the DB scope for the frontend
     */
    public function scopeFrontend($query)
    {
        return $query->with(['form' => function($query) {
            return $query->with('formFields');
        }]);
    }


    /**
     * Add to the DB scope for the frontend
     */
    public function replaceFrontendValue($original, $builder)
    {
        if(@$builder->form) {
            return $builder->form;
        }

        return new FormModel;
    }
}
