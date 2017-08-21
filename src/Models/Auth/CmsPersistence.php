<?php

namespace Thorazine\Hack\Models\Auth;

use Cartalyst\Sentinel\Persistences\EloquentPersistence;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Exception;
use Cms;
use DB;

class CmsPersistence extends EloquentPersistence
{
    
    protected $table = 'cms_persistences';

    use SoftDeletes;


    /**
     * Placeholder for types.
     */
    public $types = [];


    /**
     * Constructor
     */
    public function __construct()
    {
        // we need to force the parent construct
        parent::__construct();

        $this->types = $this->types();
    }


    /**
     * Return all the types for this module
     */
    public function types()
    {
        return [
            'id' => [
                'type' => 'number',
                'label' => 'Id',
                'regex' => '',
                'overview' => false,
                'create' => false,
                'edit' => false,
            ],
            'country' => [
                'type' => 'text',
                'label' => trans('hack::modules.persistences.country'),
                'regex' => '',
                'create' => false,
                'edit' => false,
            ],
            'city' => [
                'type' => 'text',
                'label' => trans('hack::modules.persistences.city'),
                'regex' => '',
                'create' => false,
                'edit' => false,
            ],
            'browser' => [
                'type' => 'browser',
                'label' => trans('hack::modules.persistences.browser'),
                'regex' => '',
                'create' => false,
                'edit' => false,
            ],
            'device' => [
                'type' => 'text',
                'label' => trans('hack::modules.persistences.device'),
                'regex' => '',
                'create' => false,
                'edit' => false,
            ],
            'os' => [
                'type' => 'text',
                'label' => trans('hack::modules.persistences.os'),
                'regex' => '',
                'create' => false,
                'edit' => false,
            ],
            'verified' => [
                'type' => 'checkbox',
                'label' => trans('hack::modules.persistences.verified'),
                'regex' => '',
            ],
            'created_at' => [
                'type' => 'timestamp',
                'label' => trans('hack::modules.persistences.created_at'),
                'regex' => '',
                'create' => false,
                'edit' => false,
            ],
        ];
    } 

    /**
     * Determins if a session should be activated or if verification is needed
     *
     * @param int (user_id)
     * @param double (latitude)
     * @param double (longitude)
     * @return 0|1
     */
    public function shouldBeActive($userId, $latitude, $longitude)
    {
    	// km: 6371 
    	// miles: 3959

        try {

        	$inRange = $this->select(DB::raw('
    	    		( 6371 * acos( cos( radians('.$latitude.') ) * cos( radians( cms_persistences.latitude ) ) 
    			   * cos( radians(cms_persistences.longitude) - radians('.$longitude.')) + sin(radians('.$latitude.')) 
    			   * sin( radians(cms_persistences.latitude)))) AS distance
    	    	'))
        		->having('distance', '<', config('cms.validation_distance'))
        		->where('user_id', $userId)
        		->where('verified', 1)
        		->get();        		
        		
        	if($inRange->count()) {
        		return 1;
        	}

        	// no cookie, so check if there even are other persitences for this user
        	if($this->where('user_id', $userId)->withTrashed()->count() > 1) {
        		return 0; // there are more, go validate
        	}

        	// no sessions yet, let is pass
        	return 1;

        }
        catch(Exception $e) {
            abort(500, 'There was a problem running the query. Try to set your config.database.connections.mysql setting to: strict => false');
        }
    }


    public function scopeActive($query)
    {
    	$query->where('user_id', Cms::userId())
    		->where('code', Cms::code())
    		->where('verified', 1);
    }

}
