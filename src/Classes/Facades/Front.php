<?php

namespace Thorazine\Hack\Classes\Facades;

use Illuminate\Support\Facades\Storage;
use Cms as CmsFacade;

class Front {


	public function image($id)
    {
        $file = CmsFacade::getGallery()->select('filename', 'extension')->where('id', $id)->first();

        if($file) {
            return asset(Storage::disk(config('filesystems.default'))->url('cropped/thumbnail/'.$file->fullname));
        }
        
    }


    public function asset($fullname)
    {
        

        if($fullname) {
            return asset(Storage::disk(config('filesystems.default'))->url('cropped/original/'.$fullname));
        }
        
    }


    public function pageImage($key, $page)
    {
        return $this->asset($page->{$key.'Gallery'}->fullname);
    }

    /*
     * Shorten a string and ellipse it based on length
     */
    public function str_short($value, $length = 150)
    {
        if(strlen($value) > $length) {
            return substr($value, 0, $length).'...';
        }
        return $value;
    }

}