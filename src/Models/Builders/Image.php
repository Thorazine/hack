<?php

namespace Thorazine\Hack\Models\Builders;

use Illuminate\Support\Facades\Storage;
use Thorazine\Hack\Models\Gallery;
use Builder;

class Image extends BaseBuilder
{

    /**
     * The databae table
     */
    protected $table = 'builder_images';

    /**
     * Set the type
     */
    public $type = 'image';

    /**
     * Set the type
     */
    public $appends = [


    ];


    /**
     * Constructor
     */
    public function __construct()
    {
        // we need to force the parent construct
        parent::__construct($this);

        $this->types();
    }


    /**
     * Add values to the types
     */
    public function types()
    {
        $this->addToTypes([
            'width' => [
                'type' => 'number',
                'label' => trans('modules.field.width'),
                'default' => 1280,
                'regex' => 'required',
                'appendLabel' => 'px',
            ],
            'aspect_ratio' => [
                'type' => 'aspect-ratio',
                'label' => trans('modules.field.aspect-ratio'),
                'default' => '16/6',
                'values' => [
                    '16/10' => '16/10',
                    '16/9' => '16/9',
                    '16/6' => '16/6',
                    '4/3' => '4/3',
                    '2/1' => '2/1',
                ],
                'overview' => false,
                'save' => false,
            ],
            'height' => [
                'type' => 'number',
                'label' => trans('modules.field.height'),
                'default' => 480,
                'regex' => 'required',
                'appendLabel' => 'px',
            ],
        ], 'value');

    }


    /**
     * Get all of the gallery files that belong to the image
     */
    public function image()
    {
        return $this->hasOne('Thorazine\Hack\Models\Gallery', 'id', 'value');
    }


    /**
     * Add to the DB scope for the frontend
     */
    public function scopeFrontend($query)
    {
        return $query->with('image');
    }


    /**
     * Do stuff before update
     */
    public function beforeUpdate($request, $builder, $id)
    {
        $gallery = new Gallery;

        if($request->{$builder['key']} === '0' || $request->{$builder['key']}) { // delete action

            if($builder['value']) {
                // remove old image from disk and DB
                $gallery->removeObsoleteItem($builder['value']);
            }

            if($request->{$builder['key']}) { // there is a new one, claim it
                $gallery->where('id', $request->{$builder['key']})->update([
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $gallery->removeUnused();
        }
        else {
            $request->{$builder['key']} = $builder['value'];
        }

        return $request;
    }


    /**
     * Add to the DB scope for the frontend
     */
    public function replaceFrontendValue($original, $builder)
    {
        if(@$builder->image) {
            return $builder->image;
        }

        return new Gallery;
    }

}
