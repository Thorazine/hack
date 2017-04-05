<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Http\Requests\ModuleUpdate;
use Thorazine\Hack\Models\Auth\CmsPersistence;
use Thorazine\Hack\Models\User;
use Illuminate\Http\Request;
use Hash;
use Log;
use Cms;
use DB;

class UserController extends CmsController
{

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->slug = 'user';

        parent::__construct($this);
    }


    public function show(Request $request, $id)
    {
    	if($id != Cms::user('id')) {
    		return redirect()
    			->back()
    			->with('alert-info', 'Sorry, you do not have permission to access that page');
    	}

    	$user = $this->model
    		->where('id', $id)
    		->with(['persistences' => function($query) {
    			return $query->where('verified', 1)
    				->orderBy('updated_at', 'desc');
    		}])
    		->first();

    	return view('cms.'.$this->slug.'.show')
    		->with('user', $user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModuleUpdate $request, $id)
    {
        if($id != Cms::user('id')) {
            return redirect()
                ->back()
                ->with('alert-info', 'Sorry, you do not have permission to access that page');
        }
        
        // Start insert
        try {
            DB::beginTransaction();

            $this->record = $this->queryParameters($this->model, $request)->where('id', $id)->first()->toArray();

            $request = $this->child->beforeUpdate($request, $id);

            $this->model->where('id', $id)->update($this->prepareValues($this->child->updateValues($request, $id), $id, $this->extraUpdateValues));

            $this->child->updateExtra($request, $id);

            DB::commit();

            Cms::destroyCache([$this->slug]);
        }
        catch(Exception $e) {
            return $this->rollback($e, $request, 'update');
        }

        return redirect()->route('cms.'.$this->slug.'.edit', ['id' => $id, 'fid' => $request->fid])
            ->with('alert-success', trans('cms.info.updated'));
    }


    /**
     * Get the values for updating. This function
     * makes overwriting it with an array  
     * for the child class easier
     *
     * @param  \Illuminate\Http\Request  $request|array
     * @return \Illuminate\Http\Response|array
     */
    protected function updateValues($request, $id)
    {
        $data = $request->except('password', 'password_confirmation');

        if($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        return $data;
    }


    public function destroy($id)
    {
    	try {
            DB::beginTransaction();

            // delete the pivots
            CmsPersistence::where('id', $id)->delete();

            DB::commit();

            return response()->json([
                'message' => trans('cms.deleted'),
            ]);

        }
        catch(Exception $e) {

            DB::rollBack();

            Log::error('Rollback after deletion attempt', [
                'action' => 'destroy',
                'data' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => '',
            ]);
        } 
    }
}
