<?php

namespace Thorazine\Hack\Models\Builders;

use Illuminate\Database\Eloquent\Model;

class Text extends BaseBuilder
{

    /**
     * The databae table
     */
    protected $table = 'builder_texts';

    /**
     * Set the type
     */
    public $type = 'text';


    /**
     * Constructor
     */
    public function __construct()
    {
        // we need to force the parent construct
        parent::__construct($this);
    }
}
