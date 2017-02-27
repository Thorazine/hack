<?php

namespace Thorazine\Hack\Models;

class FormField extends CmsModel
{
    protected $table = 'form_fields';


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
            'field_type' => [
                'type' => 'select',
                'label' => trans('modules.form_fields.field_type'),
                'regex' => 'required',
                'values' => config('cms.forms.types'),
            ],
            'label' => [
                'type' => 'text',
                'label' => trans('modules.form_fields.label'),
                'regex' => 'required',
            ],
            'key' => [
                'type' => 'text',
                'label' => trans('modules.form_fields.key'),
                'regex' => 'required',
            ],
            'values' => [
                'type' => 'text',
                'label' => trans('modules.form_fields.values'),
                'regex' => '',
                'overview' => false,
            ],
            'placeholder' => [
                'type' => 'text',
                'label' => trans('modules.form_fields.placeholder'),
                'regex' => '',
                'overview' => false,
            ],
            'default_value' => [
                'type' => 'text',
                'label' => trans('modules.form_fields.default_value'),
                'regex' => '',
                'overview' => false,
            ],
            'regex' => [
                'type' => 'text',
                'label' => trans('modules.form_fields.regex'),
                'regex' => '',
                'overview' => false,
            ],
            'width' => [
                'type' => 'select',
                'label' => trans('modules.form_fields.width'),
                'regex' => 'required',
                'values' => [
                    12 => '100%',
                    54 => '80%',
                    9 => '75%',
                    8 => '66%',
                    53 => '60%',
                    6 => '50%',
                    52 => '40%',
                    4 => '33%',
                    3 => '25%',
                    51 => '20%',
                    2 => '16%',
                    1 => '8%',
                ],
            ],
        ];
    }


    /**
     * Get the page record associated with the slug.
     */
    public function formFields()
    {
        return $this->blongsTo('Thorazine\Hack\Models\Form');
    }


    
}
