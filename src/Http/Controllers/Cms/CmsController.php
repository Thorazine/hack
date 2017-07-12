<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Thorazine\Hack\Http\Requests\ModuleUpdate;
use Thorazine\Hack\Http\Requests\ModuleStore;
use Thorazine\Hack\Traits\ModuleHelper;
use Thorazine\Hack\Traits\ModuleSearch;
use Thorazine\Hack\Models\Gallery;
use Thorazine\Hack\Http\Requests;
use Thorazine\Hack\Models\DbLog;
use Thorazine\Hack\Models\Site;
use Illuminate\Http\Request;
use Exception;
use Cms;
use Log;
use DB;

class CmsController extends Controller
{
    use ModuleHelper;

    use ModuleSearch;


    protected $extraCreateValues = [];
    protected $extraUpdateValues = [];
    public $types;
    public $record; // the record before update
    protected $child;
    protected $hasOrder = false; // by default there is no ordering.
    protected $paginate = true;
    protected $paginateAmount = 25;


    public function __construct($child)
    {
        $this->types = $this->model->types;
        $this->child = $child;
    }


    /**
     * Add functionality to the view
     *
     * @param  string  $query
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function viewInitialiser()
    {
        $this->model->types = $this->model->types();

        view()->share([
            'slug' => $this->slug,
            'types' => $this->model->types,
            'model' => $this->model,
            'hasOrder' => (@$this->child->hasOrder) ? $this->child->hasOrder : $this->hasOrder,
            'hasPermission' => function($action) {
                return Cms::hasPermission(Cms::siteId().'.cms.'.$this->slug.'.'.$action);
            },
            'route' => function($action) {
                return 'cms.'.$this->slug.'.'.$action;
            },
            'typeTrue' => function($type, $field, $default = true) {
                // if not excists, true
                if(array_key_exists($field, $type)) {
                    if(! $type[$field]) {
                        return false;
                    }
                    else {
                        return true;
                    }
                }
                return $default;
            },
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->viewInitialiser();

        $datas = $this->search($this->queryParameters($this->model, $request), $request);

        // apply on-the-fly filter
        if($request->filters) {
            foreach($request->filters as $filterKey => $filter) {
                $datas = $datas->where($filterKey, $filter);
            }
        }

        // if the table has a drag/drop order requirement
        if(@$this->child->hasOrder) {
            $datas = $datas->orderBy('drag_order', 'asc');
        }
        
        // add the default order
        $datas = $this->child->defaultOrder($datas);

        // if the table needs pagination
        if($this->paginate) {
            $datas = $datas->paginate($this->paginateAmount);
        }
        else {
            $datas = $datas->get();
        }

        if($request->ajax()) {
            return response()->json([
                'dataset' => view('hack::models.ajax.index')
                    ->with('datas', $datas)
                    ->with('fid', $request->fid)
                    ->with('searchFields', $this->searchFields)
                    ->render(),
                'paginate' => view('hack::models.ajax.paginate')
                    ->with('datas', $datas)
                    ->with('fid', $request->fid)
                    ->with('searchFields', $this->searchFields)
                    ->render(),
            ]);
        }

        return view('hack::models.index')
            ->with('datas', $datas)
            ->with('fid', $request->fid)
            ->with('searchFields', $this->searchFields);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->viewInitialiser();

        if(session('_old_input')) {
            $data = session('_old_input');
        }
        else {
            $data = [];
        }

        return $this->child->createExtra($request, $data);
    }


    /**
     * An easy way to break in to the 
     * create proces before sending
     * it out to the view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Collection  $data
     * @return \Illuminate\Http\Response
     */
    protected function createExtra($request, $data)
    {
        return view('hack::models.create')
            ->with('data', $data)
            ->with('fid', $request->fid);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModuleStore $request)
    {

        // Start insert
        try {
            DB::beginTransaction();

            $request = $this->child->beforeStore($request);

            $id = $this->model->insertGetId($this->prepareValues($this->child->storeValues($request), false, $this->extraCreateValues));

            $this->child->storeExtra($request, $id);

            DB::commit();

            DbLog::add(__CLASS__, 'store', json_encode($request->all()));

            Cms::destroyCache([$this->slug]);
        }
        catch(Exception $e) {
            return $this->rollback($e, $request);
        }

        return redirect()->route('cms.'.$this->slug.'.edit', ['id' => $id, 'fid' => $request->fid])
            ->with('alert-success', trans('hack::cms.info.created'));
    }


    /**
     * Get the values for saving. This function
     * makes overwriting it with an array  
     * for the child class easier
     *
     * @param  \Illuminate\Http\Request  $request|array
     * @return \Illuminate\Http\Response|array
     */
    protected function beforeStore($request)
    {
        return $request;
    }


    /**
     * Get the values for saving. This function
     * makes overwriting it with an array  
     * for the child class easier
     *
     * @param  \Illuminate\Http\Request  $request|array
     * @return \Illuminate\Http\Response|array
     */
    protected function storeValues($request)
    {
        return $request;
    }


    /**
     * An easy way the break in to
     * the save method with an
     * extra query
     *
     * @param  \Illuminate\Http\Request  $request|array
     * @return \Illuminate\Http\Response|array
     */
    protected function storeExtra($request, $id)
    {
        
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        return 'Nothing here';
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $this->viewInitialiser();
        
        if(session('_old_input')) {
            $data = session('_old_input');
        }
        else {
            $data = $this->queryParameters($this->model, $request)
                ->where('id', $id)
                ->first()
                ->toArray();
        }

        return $this->child->editExtra($request, $id, $data);
    }


    /**
     * An easy way to break in to the 
     * edit proces before sending
     * it out to the view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  Collection  $data
     * @return \Illuminate\Http\Response
     */
    protected function editExtra($request, $id, $data)
    {
        return view('hack::models.edit')
            ->with('data', $data)
            ->with('id', $id)
            ->with('fid', $request->fid);
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
        // Start insert
        try {
            DB::beginTransaction();

            $this->record = $this->queryParameters($this->model, $request)->where('id', $id)->first()->toArray();

            $request = $this->child->beforeUpdate($request, $id);

            $this->model->where('id', $id)->update($this->prepareValues($this->child->updateValues($request, $id), $id, $this->extraUpdateValues));

            $this->child->updateExtra($request, $id);

            DB::commit();

            DbLog::add(__CLASS__, 'update', json_encode($request->all()));

            Cms::destroyCache([$this->slug]);
        }
        catch(Exception $e) {
            return $this->rollback($e, $request, 'update');
        }

        return redirect()->route('cms.'.$this->slug.'.edit', ['id' => $id, 'fid' => $request->fid])
            ->with('alert-success', trans('hack::cms.info.updated'));
    }


    /**
     * Get the values for updating. This function
     * makes overwriting it with an array  
     * for the child class easier
     *
     * @param  \Illuminate\Http\Request  $request|array
     * @return \Illuminate\Http\Response|array
     */
    protected function beforeUpdate($request, $id)
    {
        return $request;
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
        return $request;
    }


    /**
     * An easy way the break in to
     * the save method with an
     * extra query
     *
     * @param  \Illuminate\Http\Request  $request|array
     * @return \Illuminate\Http\Response|array
     */
    protected function updateExtra($request, $id)
    {
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            DB::beginTransaction();

            // delete the pivots
            $this->model->where('id', $id)->delete();

            DB::commit();

            DbLog::add(__CLASS__, 'destroy', $id);

            Cms::destroyCache([$this->slug]);

            return response()->json([
                'message' => trans('hack::cms.deleted'),
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


    /**
     * ORDER
     *
     * Re-order the items
     */
    public function order(Request $request) 
    {
        try {

            DB::beginTransaction();
            
            foreach($request->order as $order => $id) {
                $this->model->where('id', $id)->update([
                    'updated_at' => date('Y-m-d H:i:s'),
                    'drag_order' => $order,
                ]);
            }

            DB::commit();

            DbLog::add(__CLASS__, 'order', json_encode($request->all()));

            Cms::destroyCache([$this->slug]);

            return response()->json([
                'success' => true,
            ]);
        }
        catch(Exception $e) {

            Log::error('Rollback after order attempt', [
                'action' => 'order',
                'data' => $request->order,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'There was an error',
            ], 500);
        }
    }


    /**
     * Possibly add query parameters to the model
     *
     * @param  string  $query
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function queryParameters($query, $request)
    {
        return $query;
    }


    /**
     * Add the default order to the model. If "hasOrder" 
     * That will take default
     *
     * @param  string  $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function defaultOrder($query)
    {
        return $query->orderBy('id');
    }
}
