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
