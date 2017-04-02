<?php

namespace Thorazine\Hack\Classes\Builders;

class Image {
	
	private $parent;


	public function __construct($parent)
	{
		$this->parent = $parent;

	}


    /**
     * Get the filesize in another format
     *
     * @param unit  string (kb|mb|gb)
     */
    public function filesize($unit = '', $precision = 2)
    {
        $size = $this->filesize;
        switch ($unit) {
            case 'kb':
                $size = $this->filesize / 1024;
                break;
            
            case 'mb':
                $size = $this->filesize / 1024 / 1024;
                break;

            case 'gb':
                $size = $this->filesize / 1024 / 1024 / 1024;
                break;
        }
        return round($size, $precision);
    }


	/**
	 * Create a little magic. Make the parent
	 * variables availible in this function
	 */
	public function __get($method)
	{
		if(@$this->parent->$method) {
			return $this->parent->$method;
		}
		return null;
	}
}