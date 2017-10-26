<?php

namespace Thorazine\Hack\Models;

use Builder;

class Site extends HackModel
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
                'label' => trans('hack::modules.sites.title'),
                'regex' => 'max:70|required',
            ],
            'protocol' => [
                'type' => 'select',
                'label' => trans('hack::modules.sites.protocol'),
                'regex' => 'required',
                'values' => [
                    'http://' => 'Http',
                    'https://' => 'Https',
                ],
            ],
            'domain' => [
                'type' => 'text',
                'label' => trans('hack::modules.sites.domain'),
                'regex' => 'required',
            ],
            'domains' => [
                'type' => 'comma-seperated',
                'label' => trans('hack::modules.sites.domains'),
                'regex' => '',
                'overview' => false,
            ],
            'language' => [
                'type' => 'select',
                'label' => trans('hack::modules.sites.language'),
                'regex' => 'required',
                'values' => 'getLanguages',
                'overview' => true,
                'default' => 'en',
            ],
            'languages' => [
                'type' => 'multi-checkbox',
                'label' => trans('hack::modules.sites.languages'),
                'regex' => '',
                'values' => 'getLanguages',
                'overview' => false,
                'grid' => 3,
            ],
            'robots' => [
                'type' => 'select',
                'label' => trans('hack::modules.sites.robots'),
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
                'type' => 'textarea',
                'label' => trans('hack::modules.sites.description'),
                'regex' => '',
                'overview' => false,
                'configuration' => 'plain',
            ],
            'keywords' => [
                'type' => 'comma-seperated',
                'label' => trans('hack::modules.sites.keywords'),
                'regex' => 'max:200',
                'overview' => false,
            ],
            'favicon' => [
                'type' => 'image',
                'label' => trans('hack::modules.sites.favicon'),
                'regex' => '',
                'width' => 32,
                'height' => 32,
                'overview' => false,
            ],
            'og_title' => [
                'type' => 'text',
                'label' => trans('hack::modules.sites.og_title'),
                'regex' => 'max:70',
                'overview' => false,
            ],
            'og_description' => [
                'type' => 'textarea',
                'label' => trans('hack::modules.sites.og_description'),
                'regex' => '',
                'overview' => false,
                'configuration' => 'plain',
            ],
            'og_type' => [
                'type' => 'text',
                'label' => trans('hack::modules.sites.og_type'),
                'regex' => 'max:200',
                'overview' => false,
                'default' => 'article',
            ],
            'og_image' => [
                'type' => 'image',
                'label' => trans('hack::modules.sites.og_image'),
                'regex' => '',
                'width' => 1200,
                'height' => 630,
                'overview' => false,
            ],
            'publish_at' => [
                'type' => 'timestamp',
                'label' => trans('hack::modules.sites.publish_at'),
                'regex' => '',
                'default' => date('Y-m-d H:i:s'),
                'position' => 'sidebar',
            ],
            'depublish_at' => [
                'type' => 'timestamp',
                'label' => trans('hack::modules.sites.depublish_at'),
                'regex' => '',
                'position' => 'sidebar',
            ],
            'browser_cache_time' => [
                'type' => 'number',
                'label' => trans('hack::modules.sites.browser_cache_time'),
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


    public function setDomainAttribute($value)
    {
    	// copy paste is an easy mistake
        $this->attributes['domain'] = str_replace(['http://', 'https://'], ['', ''], $value);
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
