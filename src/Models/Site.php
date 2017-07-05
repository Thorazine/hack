<?php

namespace Thorazine\Hack\Models;

use Builder;

class Site extends CmsModel
{
    protected $table = 'sites';

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
            'protocol' => [
                'type' => 'select',
                'label' => trans('modules.sites.protocol'),
                'regex' => '',
                'values' => [
                    'http://' => 'Http',
                    'https://' => 'Https',
                ],
            ],
            'domain' => [
                'type' => 'text',
                'label' => trans('modules.sites.domain'),
                'regex' => '',
            ],
            'domains' => [
                'type' => 'text',
                'label' => trans('modules.sites.domains'),
                'regex' => '',
                'overview' => false,
            ],
            'language' => [
                'type' => 'select',
                'label' => trans('modules.sites.language'),
                'regex' => '',
                'values' => 'getLanguages',
                'overview' => true,
                'default' => 'en',
            ],
            'languages' => [
                'type' => 'multi-checkbox',
                'label' => trans('modules.sites.languages'),
                'regex' => '',
                'values' => 'getLanguages',
                'overview' => false,
                'grid' => 3,
            ],
            'robots' => [
                'type' => 'select',
                'label' => trans('modules.sites.robots'),
                'regex' => '',
                'values' => [
                    'index, follow' => 'Index, follow',
                    'noindex, follow' => 'No index, follow',
                    'index, nofollow' => 'Index, no follow',
                    'noindex, nofollow' => 'No index, no follow',
                ],
                'overview' => false,
            ],
            'description' => [
                'type' => 'wysiwyg',
                'label' => trans('modules.sites.description'),
                'regex' => '',
                'overview' => false,
                'configuration' => 'plain',
            ],
            'keywords' => [
                'type' => 'text',
                'label' => trans('modules.sites.keywords'),
                'regex' => 'max:200',
                'overview' => false,
            ],
            'favicon' => [
                'type' => 'image',
                'label' => trans('modules.sites.favicon'),
                'regex' => '',
                'width' => 32,
                'height' => 32,
                'overview' => false,
            ],
            'og_title' => [
                'type' => 'text',
                'label' => trans('modules.sites.og_title'),
                'regex' => 'max:70',
                'overview' => false,
            ],
            'og_description' => [
                'type' => 'wysiwyg',
                'label' => trans('modules.sites.og_description'),
                'regex' => '',
                'overview' => false,
                'configuration' => 'plain',
            ],
            'og_type' => [
                'type' => 'text',
                'label' => trans('modules.sites.og_type'),
                'regex' => 'max:200',
                'overview' => false,
                'default' => 'article',
            ],
            'og_image' => [
                'type' => 'image',
                'label' => trans('modules.sites.og_image'),
                'regex' => '',
                'width' => 1200,
                'height' => 630,
                'overview' => false,
            ],
            'publish_at' => [
                'type' => 'timestamp',
                'label' => trans('modules.sites.publish_at'),
                'regex' => '',
                'default' => date('Y-m-d H:i:s'),
                'position' => 'sidebar',
            ],
            'depublish_at' => [
                'type' => 'timestamp',
                'label' => trans('modules.sites.depublish_at'),
                'regex' => '',
                'position' => 'sidebar',
            ],
            'browser_cache_time' => [
                'type' => 'number',
                'label' => trans('modules.sites.browser_cache_time'),
                'regex' => 'numeric|required',
                'default' => 300,
                'overview' => false,
            ],
        ];
    } 


    /**
     *
     */
    public function pages()
    {
        return $this->hasMany('Thorazine\Hack\Models\Page');
    }


    /**
     *
     */
    public function getLanguages()
    {
        return Builder::getLanguageAsArray();
    }


    public function getLanguagesAttribute($value)
    {
        if(! $value) {
            return [];
        }
        return explode(',', $value);
    }


    public function beforeLanguagesSave($value)
    {
        return implode(',', $value);
    }

}
