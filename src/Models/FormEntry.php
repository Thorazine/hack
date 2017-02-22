<?php

namespace Thorazine\Hack\Models;

class FormEntry extends CmsModel
{
    protected $table = 'form_entries';


    /**
     * Constructor
     */
    public function __construct()
    {
        // we need to force the parent construct
        parent::__construct($this);

        $this->types = $this->types();
    }


    /**
     * Return all the types for this module
     */
    public function types()
    {
        return [
            'id' => [
                'type' => 'number',
                'label' => 'Id',
                'regex' => '',
                'overview' => false,
                'create' => false,
                'edit' => false,
            ],
        ];
    }


    /**
     * Get the page record associated with the slug.
     */
    public function form()
    {
        return $this->blongsTo('Thorazine\Hack\Models\Form');
    }


    /**
     * Get the page record associated with the slug.
     */
    public function formValues()
    {
        return $this->hasMany('Thorazine\Hack\Models\FormValue');
    }


    
}
