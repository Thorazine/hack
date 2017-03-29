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
     * Get the form entry it belongs to
     */
    public function formEntry()
    {
        return $this->blongsTo('Thorazine\Hack\Models\FormEntry');
    }


    /**
     * Take the values, split them and return them as array
     */
    public function valuesAsArray()
    {
        $values = explode('|', $this->values);

        $array = [];
        foreach($values as $value) {
            if(strpos($value, '~') !== false) {
                $valueLabel = explode('~', $value);
                $array[$valueLabel[0]] = $valueLabel[1];
            }
            else {
                $array[$value] = $value;
            }
        }

        return $array;
    }


    
}
