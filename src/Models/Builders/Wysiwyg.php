<?php

namespace Thorazine\Hack\Models\Builders;

use Illuminate\Database\Eloquent\Model;

class Wysiwyg extends BaseBuilder
{

    /**
     * The databae table
     */
    protected $table = 'builder_wysiwygs';

    /**
     * Set the type
     */
    public $type = 'wysiwyg';


    /**
     * Constructor
     */
    public function __construct()
    {
        // we need to force the parent construct
        parent::__construct($this);

        $this->types();
    }


    /**
     * Return all the types for this module
     */
    public function types()
    {
        $this->addToTypes([
            'configuration' => [
                'type' => 'select',
                'label' => trans('modules.field.configuration'),
                'regex' => 'required',
                'values' => array_reduce(config('cms.modules.wysiwyg.values'), function ($result, $item) {
                    $result[$item] = trans('cms.wysiwyg-values.'.$item);
                    return $result;
                }, []),
            ],
        ], 'value');
    }
}
