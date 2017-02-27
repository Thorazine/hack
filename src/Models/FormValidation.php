<?php

namespace Thorazine\Hack\Models;

class FormValidation extends CmsModel
{
    protected $table = 'form_validations';


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
            'label' => [
                'type' => 'text',
                'label' => 'Label',
                'regex' => 'required',
            ],
            'regex' => [
                'type' => 'text',
                'label' => 'Regex',
                'regex' => 'required',
            ],
            'error_message' => [
                'type' => 'text',
                'label' => 'Error message',
                'regex' => '',
            ],
        ];
    }    
}
