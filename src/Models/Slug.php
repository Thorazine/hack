<?php

namespace Thorazine\Hack\Models;

class Slug extends HackModel
{
    protected $table = 'slugs';


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
            'slug' => [
                'type' => 'text',
                'label' => trans('hack::modules.slugs.slug'),
                'regex' => 'required',
            ],
            'page_id' => [
                'type' => 'label',
                'label' => trans('hack::modules.slugs.page_id'),
                'regex' => '',
                'alternativeValue' => [
                    'index' => function($data, $key) {
                        return $data->page->prepend_slug.'/'.$data->page->slug;
                    },
                ],
            ],
        ];
    }


    /**
     * Get the page record associated with the slug.
     */
    public function page()
    {
        return $this->belongsTo('Thorazine\Hack\Models\Page');
    }



}
