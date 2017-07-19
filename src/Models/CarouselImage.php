<?php

namespace Thorazine\Hack\Models;

use Thorazine\Hack\Classes\Builders\FormBuilder;
use Thorazine\Hack\Scopes\SiteScope;
use Thorazine\Hack\Models\CmsModel;
use Storage;
use Cms;

class CarouselImage extends CmsModel
{
    protected $table = 'carousel_images';

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
            'image' => [
                'type' => 'image',
                'label' => trans('hack::modules.carousel_images.image'),
                'width' => false, // is set through the controller
                'height' => false, // is set through the controller
                'regex' => 'required',
            ],
            'body' => [
                'type' => 'wysiwyg',
                'label' => trans('hack::modules.carousel_images.body'),
                'regex' => '',
                'configuration' => 'full',
                'overview' => false,
            ],
            'options' => [
                'type' => 'value-label',
                'label' => trans('hack::modules.carousel_images.body'),
                'regex' => '',
                'configuration' => 'full',
                'overview' => false,
            ],
        ];
    }

    /**
     * Example function for adding an image to this module
     * In this case the image relates to the "image" field
     */
    public function gallery()
    {
        return $this->hasOne('Thorazine\Hack\Models\Gallery', 'id', 'image');
    }

    /**
     * Load the carousel
     */
    public function carousel()
    {
        return $this->hasOne('Thorazine\Hack\Models\Carousel');
    }
}
