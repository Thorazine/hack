<?php

namespace Thorazine\Hack\Models;

use Request;
use Cms;

class MenuItem extends CmsModel
{
    protected $table = 'menu_items';


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
            'page_id' => [
                'type' => 'select',
                'label' => trans('hack::modules.menu_items.page_id'),
                'regex' => '',
                'values' => 'getPages',
                'placeholder' => trans('hack::cms.placeholder.menu_items.page_id'),
            ],
            'external_url' => [
                'type' => 'text',
                'label' => trans('hack::modules.menu_items.external_url'),
                'regex' => '',
            ],
            'title' => [
                'type' => 'text',
                'label' => trans('hack::modules.menu_items.title'),
                'regex' => '',
            ],
            'description' => [
                'type' => 'text',
                'label' => trans('hack::modules.menu_items.description'),
                'regex' => '',
            ],
            'target' => [
                'type' => 'select',
                'label' => trans('hack::modules.menu_items.target'),
                'regex' => '',
                'default' => '_self',
                'values' => [
                    '_blank' => '_blank',
                    '_self' => '_self',
                    '_parent' => '_parent',
                    '_top' => '_top',
                ],
            ],
            'active' => [
                'type' => 'checkbox',
                'label' => trans('hack::modules.menu_items.active'),
                'regex' => '',
                'default' => 1,
            ],
        ];
    } 


    /**
     * Return the url
     */
    public function __toString()
    {
        if($this->external_url) {
            return $this->external_url;
        }
        elseif(@$this->page) {
            return $this->page->toUrl();
        }
        return '';
    }


    public function getActiveAttribute()
    {
        if(rtrim($this->external_url, '/') == Request::url()) {
            return true;
        }
        elseif(@rtrim($this->page, '/') == Request::url()) {
            return true;
        }
        return false;
    }


    public function activeHtml($html)
    {
        if($this->active) {
            return $html;
        }
        return '';
    }


    /**
     *
     */
    public function menu()
    {
        return $this->belongsTo('Thorazine\Hack\Models\Menu');
    }


    /**
     * A menu item can be linked to a page for it's url
     */
    public function page()
    {
        return $this->hasOne('Thorazine\Hack\Models\Page', 'id', 'page_id');
    }


    /**
     * Get the pages for a select menu
     */
    public function getPages()
    {
        if(@$this->getPagesData) {
            return $this->getPagesData; 
        }

        $pages = Page::get();
        $return = ['' => trans('hack::cms.placeholder.menu_items.page_id')];
        foreach($pages as $index => $page) {
            $return[$page->id] = $page->url;
        }

        $this->getPagesData = $return;

        return $this->getPagesData;
    }
}
