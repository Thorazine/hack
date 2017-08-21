<?php

namespace Thorazine\Hack\Models;

class Pageable extends CmsModel
{
    protected $table = 'pageables';


    /**
     * Constructor
     */
    public function __construct()
    {
        // we need to force the parent construct
        parent::__construct($this);
    }
}
