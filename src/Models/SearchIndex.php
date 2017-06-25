<?php

namespace Thorazine\Hack\Models;

use Builder;

class SearchIndex extends CmsModel
{
    protected $table = 'search_index';

    /**
     * Placeholder for current site data.
     */
    public static $site;


    /**
     * Constructor
     */
    public function __construct()
    {

        $this->types = $this->types();

        // we need to force the parent construct
        parent::__construct($this);
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
            'title' => [
                'type' => 'text',
                'label' => trans('modules.sites.title'),
                'regex' => 'max:70',
            ],
        ];
    } 

}
