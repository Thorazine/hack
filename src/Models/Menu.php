<?php

namespace Thorazine\Hack\Models;

use Thorazine\Hack\Scopes\SiteScope;
use Thorazine\Hack\Models\MenuItem;

class Menu extends HackModel
{
    protected $table = 'menus';


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
            'title' => [
                'type' => 'text',
                'label' => trans('hack::modules.menu.title'),
                'regex' => 'required',
            ],
            'max_levels' => [
                'type' => 'select',
                'label' => trans('hack::modules.menu.max_levels'),
                'regex' => 'required|numeric',
                'default' => 2,
                'values' => [
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5,
                ],
            ],
        ];
    }


    /**
     *
     */
    public function menuItems()
    {
        return $this->hasMany('Thorazine\Hack\Models\MenuItem')->orderBy('drag_order', 'asc')->orderBy('depth', 'asc');
    }


    /**
     * Get all the menus
     */
    public function getMenus()
    {
        return ['' => 'None']+$this->select('id', 'title')->orderBy('title', 'asc')->pluck('title', 'id')->toArray();
    }


    /**
     * Return the url
     */
    public function has()
    {
        if(@$this->MenuItem) {
            return true;
        }
        return false;
    }
}
