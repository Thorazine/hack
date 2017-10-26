<?php

namespace Thorazine\Hack\Models;

use Hack;

class FormValidation extends HackModel
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
            'language' => [
                'type' => 'select',
                'label' => trans('hack::modules.form_validations.language'),
                'regex' => 'required',
                'values' => 'getLanguages',
            ],
            'label' => [
                'type' => 'text',
                'label' => trans('hack::modules.form_validations.label'),
                'regex' => 'required',
            ],
            'regex' => [
                'type' => 'text',
                'label' => trans('hack::modules.form_validations.regex'),
                'regex' => 'required',
            ],
            'error_message' => [
                'type' => 'text',
                'label' => trans('hack::modules.form_validations.error_message'),
                'regex' => '',
            ],
        ];
    }


    /**
     * Get all of the module owners.
     */
    public function getLanguages($data = [], $key = '')
    {
        $languages = [];
        foreach(Hack::site('languages') as $language) {
            $languages[$language] = $language;
        }
        return $languages;
    }
}
