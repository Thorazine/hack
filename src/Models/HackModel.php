<?php

namespace Thorazine\Hack\Models;

use Illuminate\Database\Eloquent\Model;
use Hack;

class HackModel extends Model
{

	private $child;

    private $images = [];


    /**
     * Placeholder for types.
     */
    public $types = [];

    /**
     * Constructor
     */
    public function __construct($child)
    {
        // we need to force the parent construct
        parent::__construct();

        $this->child = $child;

    }


    /**
     * Dynamically load the builder (or another class). This way you can load your own if needbe
     */
    public function builder($module, $key = 'builder')
    {
        $namespace = config('cms.builders.'.$module.'.'.$key);
        return new $namespace($this->child);
    }


    public function addInitiator($initiator)
    {
        Hack::addInitiator($initiator);
    }

}
