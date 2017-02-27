<?php

namespace Thorazine\Hack\Models;

class FormValue extends CmsModel
{
    protected $table = 'form_values';


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
            'value' => [
                'type' => 'text',
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
    public function formEntry()
    {
        return $this->blongsTo('Thorazine\Hack\Models\FormEntry');
    }


    
}
