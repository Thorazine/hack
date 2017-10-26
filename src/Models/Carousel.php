<?php

namespace Thorazine\Hack\Models;

use Thorazine\Hack\Classes\Builders\FormBuilder;
use Thorazine\Hack\Scopes\SiteScope;
use Thorazine\Hack\Models\HackModel;
use Hack;

class Carousel extends HackModel
{
    protected $table = 'carousels';

    protected $builder;


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
                'label' => trans('hack::modules.carousels.title'),
                'regex' => 'required',
            ],
            'width' => [
                'type' => 'text',
                'label' => trans('hack::modules.carousels.width'),
                'regex' => 'required',
            ],
            'height' => [
                'type' => 'text',
                'label' => trans('hack::modules.carousels.height'),
                'regex' => 'required',
            ],
            'options' => [
                'type' => 'value-label',
                'label' => trans('hack::modules.carousels.options'),
                'regex' => 'required',
                'overview' => false,
            ],
        ];
    }

    /**
     * Load the images
     */
    public function carouselImages()
    {
        return $this->hasMany('Thorazine\Hack\Models\CarouselImage');
    }


    /**
     * Get all the forms
     */
    public function getCarousels()
    {
        return ['' => 'None']+$this->select('id', 'title')->orderBy('title', 'asc')->pluck('title', 'id')->toArray();
    }


    /**
     * Return the url
     */
    public function has()
    {
        if(@$this->carouselImages) {
            return true;
        }
        return false;
    }
}
