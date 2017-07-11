<?php
namespace Thorazine\Hack\Models\Builders;

use Illuminate\Database\Eloquent\Model;

class BaseBuilder extends Model
{
    // store the child namespace
    private $child; 

    /**
     * Append to output
     */
    protected $appends = ['type'];

    /**
     * placeholder for types
     */
    public $types = [];


    /**
     * Constructor
     */
    public function __construct($child = false)
    {

        $this->child = $child;

        // catch if the user uses an append an doesn't add the type
        if($this->child) {
            if(! in_array('type', $this->child->appends)) {
                array_push($this->child->appends, 'type');
            }
        }

        // we need to force the parent construct
        parent::__construct();

        $this->createTypes();
    }


    /**
     * Add the type to the db output
     */
    public function getTypeAttribute()
    {
        return $this->child->type;
    }


    /**
     * Return all the types for this module
     */
    public function createTypes()
    {
        $this->types = [
            'id' => [
                'type' => 'integer',
                'label' => 'Id',
                'regex' => '',
                'overview' => false,
                'create' => false,
                'edit' => false,
            ],
            'label' => [
                'type' => 'text',
                'label' => trans('hack::modules.field.label'),
                'regex' => 'required',
            ],
            'key' => [
                'type' => 'text',
                'label' => trans('hack::modules.field.key'),
                'regex' => 'required',
            ],
            'value' => [
                'builder' => false,
                'type' => 'text',
                'label' => trans('hack::modules.field.value'),
                'regex' => '',
            ],
            'default_value' => [
                'type' => 'text',
                'label' => trans('hack::modules.field.default_value'),
                'regex' => '',
            ],
            'create_regex' => [
                'type' => 'text',
                'label' => trans('hack::modules.field.create_regex'),
                'regex' => '',
                'overview' => false,
            ],
            'edit_regex' => [
                'type' => 'text',
                'label' => trans('hack::modules.field.edit_regex'),
                'regex' => '',
                'overview' => false,
            ],
        ];

        // check if there is an additive for the types on the child
        if(method_exists($this->child, 'types')) {
            // $this->child->types();
        }
    }


    public function addToTypes($array, $key = 'id')
    {
        $offset = array_search($key, array_keys($this->types));

        $this->types = array_merge(
            array_slice($this->types, 0, $offset),
            $array,
            array_slice($this->types, $offset, null)
        );
    }


    /**
     * Do stuff before store
     */
    public function beforeStore($request, $builder, $id)
    {
        return $request;
    }


    /**
     * Do stuff before update
     */
    public function beforeUpdate($request, $builder, $id)
    {
        return $request;
    }


    /**
     * Add to the DB scope for the frontend
     */
    public function scopeFrontend($query)
    {
        return $query;
    }


    /**
     * Add to the DB scope for the frontend
     */
    public function replaceFrontendValue($original, $builder)
    {
        return $builder->value;
    }


    /**
     * Add to the DB scope for the frontend
     */
    public function page()
    {
        return $this->morphToMany('Thorazine\Hack\Models\Page', 'pageable');
    }



}