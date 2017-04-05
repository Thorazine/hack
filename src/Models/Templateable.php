<?php

namespace Thorazine\Hack\Models;

class Templateable extends CmsModel
{
    /**
     * The databae table
     */
    protected $table = 'templateables';


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
        	'type' => [
        		'type' => 'label',
        		'label' => 'Type',
        	],
	        'key' => [
	        	'type' => 'text',
	            'label' => 'Refrence',
	        ],
	        'label' => [
	        	'type' => 'text',
	            'label' => 'Label',
	        ],
	    ];
	}
}
