<?php

namespace Thorazine\Hack\Traits;

// use Illuminate\Foundation\Application;
use Thorazine\Hack\Models\Gallery;
use Cms;
use Log;
use DB;

trait ModuleHelper {
	
	public $except = [
		'_token',
		'id',
		'fid',
		'module',
		'_method',
		'pivot',
		'created_at',
		'updated_at',
		'deleted_at',
	];


	/*
	 * Prepare the values before input
	 */
	protected function prepareValues($request, $id, $additionals = [])
	{
		// give the option to pre filter. In that case we're expecting an array to make it easier
		if(is_array($request)) {
			$data = array_except($request, $this->except);
		}
		else {
			$data = $request->except($this->except);
		}

		// do we need to alter an attribute
		foreach($data as $key => $value) {			
			$data = $this->handleBefore($key, $value, $data);
			$data = $this->handleTimestamp($key, $value, $data);
			$data = $this->handleImage($key, $value, $data);
		}

		// set the timestamps for create or update
		$data = $this->setTimestamps($id, $data);

		// add the additional values 
		foreach($additionals as $additionalKey => $additionalValue) {
			$data[$additionalKey] = $additionalValue;
		}

		return $data;
	}


	/*
	 * Prepare the values before input
	 */
	protected function rollback($e, $request, $action = 'insert')
	{
	    DB::rollBack();

        Log::error('Rollback after query attempt', [
            'action' => $action,
            'data' => $request,
            'error' => $e->getMessage(),
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->with('alert-danger', (env('APP_DEBUG')) ? trans('cms.error.rollback').'<br>'.$e->getMessage() : trans('cms.error.rollback'));
	}


	/*
	 * Prepare the image values before input
	 */
	protected function handleImage($key, $value, $data)
	{
		if(@$this->types[$key]['type'] == 'image') {

			if($value == '0' || $value) {

				if(@$this->record[$key]) {
					Cms::getGallery()->removeObsoleteItem($this->record[$key]);
				}

				if($value) { // there is a new one, claim it
	                Cms::getGallery()->where('id', $value)->update([
	                    'updated_at' => date('Y-m-d H:i:s'),
	                ]);
	            }
	            else {
	            	$data[$key] = '';
	            }

	            Cms::getGallery()->removeUnused();
				
			}
			else {
				$data[$key] = $this->record[$key];
			}
		}
		return $data;
	}


	/*
	 * Prepare the timestamp value before input
	 */
	protected function handleTimestamp($key, $value, $data)
	{
		if(@$this->types[$key] && $this->types[$key]['type'] == 'timestamp' && $value == '') {
			$data[$key] = null;
		}
		return $data;
	}


	/*
	 * Check if there is an action to do before save
	 */
	protected function handleBefore($key, $value, $data)
	{
		if(@$this->types[$key] && method_exists($this->model, 'before'.ucfirst(camel_case($key)).'Save')) {
			$data[$key] = $this->model->{'before'.ucfirst(camel_case($key)).'Save'}($value);
		}
		return $data;
	}


	/*
	 * Set the timestamps for create and update
	 */
	protected function setTimestamps($id, $data)
	{
		if($id) { // update
            $data['updated_at'] = date('Y-m-d H:i:s');
		}
		else { // insert
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
		}
		return $data;
	}
}