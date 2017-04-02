<?php

namespace Thorazine\Hack\Models\Builders;

use Illuminate\Database\Eloquent\Model;
use Thorazine\Hack\Models\Menu as MenuModel;

class Menu extends BaseBuilder
{

    /**
     * The databae table
     */
    protected $table = 'builder_menus';

    /**
     * Set the type
     */
    public $type = 'menu';


    /**
     * Constructor
     */
    public function __construct()
    {
        // we need to force the parent construct
        parent::__construct($this);
    }


    /**
     * Get all of the galley files that belong to the image
     */
    public function menu()
    {
        return $this->hasOne('Thorazine\Hack\Models\Menu', 'id', 'value');
    }


    /**
     * Add to the DB scope for the frontend
     */
    public function scopeFrontend($query)
    {
        return $query->with('menu.menuItems.page');
    }


    /**
     * Add to the DB scope for the frontend
     */
    public function replaceFrontendValue($original, $builder)
    {
        if(@$builder->menu) {
            return $builder->menu;
        }
        return new MenuModel;
    }
}
