<?php

namespace Thorazine\Hack\Models;

use Thorazine\Hack\Scopes\SiteScope;

class NotFound extends CmsModel
{
    protected $table = 'not_found';


    protected $fillable = [
        'site_id',
        'slug',
        'referrer',
        'requests',
    ];


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
            'requests' => [
                'type' => 'number',
                'label' => trans('modules.not_found.requests'),
                'regex' => '',
                'create' => false,
                'edit' => false,
            ],
            'slug' => [
                'type' => 'text',
                'label' => trans('modules.not_found.slug'),
                'regex' => 'required',
            ],
            'redirect' => [
                'type' => 'text',
                'label' => trans('modules.not_found.redirect'),
                'regex' => 'required',
            ],
            'referrer' => [
                'type' => 'text',
                'label' => trans('modules.not_found.referrer'),
                'regex' => '',
                'create' => false,
                'edit' => false,
            ],
        ];
    } 
}
