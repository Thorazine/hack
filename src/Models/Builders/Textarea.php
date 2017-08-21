<?php

namespace Thorazine\Hack\Models\Builders;

use Illuminate\Database\Eloquent\Model;

class Textarea extends BaseBuilder
{

    /**
     * The databae table
     */
    protected $table = 'builder_textareas';

    /**
     * Set the type
     */
    public $type = 'textarea';


    /**
     * Constructor
     */
    public function __construct()
    {
        // we need to force the parent construct
        parent::__construct($this);
    }
}
