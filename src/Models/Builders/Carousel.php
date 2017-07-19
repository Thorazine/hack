<?php

namespace Thorazine\Hack\Models\Builders;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cms\Carousel as CarouselModel;

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
     * Add to the DB scope for the frontend
     */
    // public function replaceFrontendValue($original, $builder)
    // {
    //     if(@$builder->cta) {
    //         return $builder->cta;
    //     }

    //     return new CtaModel;
    // }
}
