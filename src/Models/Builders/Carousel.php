<?php

namespace Thorazine\Hack\Models\Builders;

use Illuminate\Database\Eloquent\Model;
use Thorazine\Hack\Models\Carousel as CarouselModel;

class Carousel extends BaseBuilder
{

    /**
     * The databae table
     */
    protected $table = 'builder_carousels';

    /**
     * Set the type
     */
    public $type = 'carousel';


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
    public function carousel()
    {
        return $this->hasOne('Thorazine\Hack\Models\Carousel', 'id', 'value');
    }


    /**
     * Add to the DB scope for the frontend
     */
    public function scopeFrontend($query)
    {
        return $query->with('carousel.carouselImages.gallery');
    }


    /**
     * Add to the DB scope for the frontend
     */
    public function replaceFrontendValue($original, $builder)
    {
        if(@$builder->carousel) {
            return $builder->carousel;
        }
        return new CarouselModel;
    }
}
