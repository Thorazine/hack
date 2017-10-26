<?php

namespace Thorazine\Hack\Models;

use Thorazine\Hack\Scopes\SiteScope;
use Hack;

class Template extends HackModel
{
    /**
     * The databae table
     */
    protected $table = 'templates';


    /**
     * All the morph relation placeholder
     */
    protected $morphs = [];


    /**
     * Constructor
     */
    public function __construct()
    {
        // we need to force the parent construct
        parent::__construct($this);

        $this->types = $this->types();

        // add all the modules to the array so they can be
        // caught by the realtional builder
        if(config('cms.builders')) {
            foreach(config('cms.builders') as $key => $values) {
                $this->morphs[str_plural($key)] = $values;
            }
        }
    }


    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SiteScope);
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
            'refrence' => [
                'type' => 'text',
                'label' => trans('hack::modules.templates.refrence'),
                'regex' => 'required',
            ],
            'prepend_slug' => [
                'type' => 'text',
                'label' => trans('hack::modules.templates.prepend_slug'),
                'regex' => '',
                'beforeSave' => function($value) {
                    return trim(trim($value, '/'));
                },
            ],
            'view' => [
                'type' => 'text',
                'label' => trans('hack::modules.templates.view'),
                'regex' => 'required',
                'default' => 'default',
            ],
            'pages' =>[
                'type' => 'label',
                'label' => trans('hack::modules.templates.pages'),
                'alternativeValue' => [
                    'index' => function($data, $key) {
                        return @count($data->pages);
                    },
                ],
                'create' => false,
                'edit' => false,
            ]
        ];
    }


    /*
     * Catch all the methods for this model. Filter out the
     * relational requests so we can automatically make
     * a relational query for it based on the array
     * This is only for eager loading. Send the
     * rest to the model function in extend
     */
    public function __call($method, $arguments)
    {
        if(in_array($method, array_keys($this->morphs))) {
            return $this->morphedByMany($this->morphs[$method]['namespace'], 'templateable')->withPivot('id', 'drag_order');
        }
        return parent::__call($method, $arguments);
    }




    /*
     * Catch all the lazy loaded requests to this class
     * and overwrite a model class function with an
     * other of our own. We added a OR function
     */
    public function getRelationValue($key)
    {
        // If the key already exists in the relationships array, it just means the
        // relationship has already been loaded, so we'll just return it out of
        // here because there is no need to query within the relations twice.
        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }

        // If the "attribute" exists as a method on the model, we will just assume
        // it is a relationship and will load and return results from the query
        // and hydrate the relationship's value on the "relationships" array.
        if (method_exists($this, $key) || in_array($key, array_keys($this->morphs))) {
            return $this->getRelationshipFromMethod($key);
        }
    }


    /**
     * Get all the pages that are connected to this template
     */
    public function pages()
    {
        return $this->hasMany('Thorazine\Hack\Models\Page');
    }


    /**
     * get the prepend label for slug
     */
    public function prependPrependSlugLabel($data, $key)
    {
        return Hack::site('protocol').Hack::site('domain').'/';
    }

}


