<?php

namespace Thorazine\Hack\Models;

class FormField extends HackModel
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
                'type' => 'create-value-edit-label',
                'label' => trans('hack::modules.form_fields.field_type'),
                'regex' => 'required',
                'values' => 'getFieldTypes',
            ],
            'overview' => [
                'type' => 'select',
                'label' => trans('hack::modules.form_fields.overview'),
                'regex' => '',
                'default' => 1,
                'values' => [
                    '1' => trans('hack::modules.form_fields.visible'),
                    '' => trans('hack::modules.form_fields.invisible'),
                ],
                'overview' => false,
            ],
            'label' => [
                'type' => 'text',
                'label' => trans('hack::modules.form_fields.label'),
                'regex' => 'required',
            ],
            'key' => [
                'type' => 'text',
                'label' => trans('hack::modules.form_fields.key'),
                'regex' => 'required',
            ],
            'values' => [
                'type' => 'text',
                'label' => trans('hack::modules.form_fields.values'),
                'regex' => '',
                'overview' => false,
            ],
            'placeholder' => [
                'type' => 'text',
                'label' => trans('hack::modules.form_fields.placeholder'),
                'regex' => '',
                'overview' => false,
            ],
            'default_value' => [
                'type' => 'text',
                'label' => trans('hack::modules.form_fields.default_value'),
                'regex' => '',
                'overview' => false,
            ],
            'regex' => [
                'type' => 'text',
                'label' => trans('hack::modules.form_fields.regex'),
                'regex' => '',
                'overview' => false,
            ],
            'width' => [
                'type' => 'select',
                'label' => trans('hack::modules.form_fields.width'),
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
     * Get the form that belongs to these fields
     */
    public function form()
    {
        return $this->belongsTo('Thorazine\Hack\Models\Form');
    }


    /**
     * Take the values, split them and return them as array
     */
    public function valuesAsArray()
    {
        return json_decode($this->values);
    }

    /**
     * @param  array
     * @param  string
     * @return array
     */
    public function getFieldTypes($data = [], $key = '')
    {
        $types = [];
        foreach(config('cms.forms.types') as $value => $values) {
            $types[$value] = $values['label'];
        }
        return $types;
    }



}
