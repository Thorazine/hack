<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Thorazine\Hack\Http\Requests\BuilderUpdate;
use Thorazine\Hack\Http\Requests\BuilderStore;
use Illuminate\Http\Request;
use Thorazine\Hack\Traits\ModuleSearch;
use Thorazine\Hack\Traits\ModuleHelper;
use Thorazine\Hack\Models\Templateable;
use Thorazine\Hack\Models\Template;
use Thorazine\Hack\Models\Pageable;
use Thorazine\Hack\Http\Requests;
use Thorazine\Hack\Models\DbLog;
use Thorazine\Hack\Models\Page;
use Exception;
use Builder;
use Cms;
use Log;
use DB;

class BuilderController
{
    use ModuleHelper;

    use ModuleSearch;

    public function __construct(Template $model, Templateable $templateable, Page $page, Pageable $pageable)
    {
        $this->model = $model;
        $this->templateable = $templateable;
        $this->pageable = $pageable;
        $this->page = $page;
        $this->slug = 'builder';

        $this->model->types = $templateable->types;

        // parent::__construct($this);

        // set the create route
        $this->types = $this->model->types;

        view()->share([
            'hasOrder' => true,
            'createRoute' => 'cms.'.$this->slug.'.module',
            'slug' => $this->slug,
            'types' => $this->types,
            'model' => $this->model,
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
        // get builders
        $datas = Builder::getTemplateBuilders($request->fid, $this->model, false);

        if($request->ajax()) {
            return response()->json([
                'dataset' => view('hack::builder.ajax.index')
                    ->with('datas', $datas)
                    ->with('fid', $request->fid)
                    ->with('searchFields', $this->searchFields)
                    ->render(),
                'paginate' => view('hack::model.ajax.paginate')
                    ->with('datas', $datas)
                    ->with('fid', $request->fid)
                    ->with('searchFields', $this->searchFields)
                    ->render(),
            ]);
        }

        return view('hack::builder.index')
            ->with('datas', $datas)
            ->with('fid', $request->fid);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function module(Request $request)
    {
        return view('hack::builder.module')
            ->with('fid', $request->fid);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(session('_old_input')) {
            $data = session('_old_input');
        }
        else {
            $data = [];
        }

        // get the type values
        $namespace = config('cms.modules.'.$request->module.'.namespace');

        $moduleClass = new $namespace;

        foreach($moduleClass->types as $key => $values) {
            if(array_key_exists('builder', $values) && ! $values['builder']) {
                unset($moduleClass->types[$key]);
            }
        }

        return view('hack::builder.create')
            ->with('data', $data)
            ->with('types', $moduleClass->types)
            ->with('fid', $request->fid)
            ->with('module', $request->module);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BuilderStore $request)
    {

        // Start insert
        try {
            DB::beginTransaction();

            // get the type values
            $namespace = config('cms.modules.'.$request->module.'.namespace');

            $moduleClass = new $namespace;

            $moduleId = $moduleClass->insertGetId($request->except($this->except)+[
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $templateableId = $this->templateable->insertGetId([
                'template_id' => $request->fid,
                'templateable_id' => $moduleId,
                'templateable_type' => $namespace,
            ]);

            // Add the newly created to the current Page
            $pageIds = $this->page
                ->where('template_id', $request->fid)
                ->pluck('id');

            foreach($pageIds as $pageId) {

                $pageModuleId = $moduleClass->insertGetId($request->except($this->except)+[
                    'template_sibling' => $moduleId,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                $pageableId = $this->pageable->insertGetId([
                    'page_id' => $pageId,
                    'pageable_id' => $pageModuleId,
                    'pageable_type' => $namespace,
                ]);
            }

            DB::commit();

            DbLog::add(__CLASS__, 'store', json_encode($request->all()));

            Cms::destroyCache([$this->slug]);
        }
        catch(Exception $e) {
            return $this->rollback($e, $request);
        }

        return redirect()->route('cms.builder.edit', ['id' => $templateableId, 'fid' => $request->fid])
            ->with('alert-success', trans('cms.info.created'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data = $this->templateable
            ->where('id', $id)
            ->first();

        $moduleClass = new $data->templateable_type;

        if(session('_old_input')) {
            $moduleData = session('_old_input');
        }
        else {
            $moduleData = $moduleClass
                ->where('id', $data->templateable_id)
                ->first()
                ->toArray();
        }

        foreach($moduleClass->types as $key => $values) {
            if(array_key_exists('builder', $values) && ! $values['builder']) {
                unset($moduleClass->types[$key]);
            }
        }

        return view('hack::builder.edit')
            ->with('types', $moduleClass->types)
            ->with('fid', $request->fid)
            ->with('data', $moduleData)
            ->with('id', $id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BuilderUpdate $request, $id)
    {
        // Start insert
        try {
            DB::beginTransaction();

            $data = $this->templateable
                ->where('id', $id)
                ->first();

            $moduleClass = new $data->templateable_type;

            array_push($this->except, 'module_id');

            $moduleClass->where('id', $request->module_id)
                ->update($request->except($this->except)+[
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            // update all the sibling that derive from this module
            $moduleClass->where('template_sibling', $request->module_id)
                ->update($request->except($this->except+['value'])+[
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            DB::commit();

            DbLog::add(__CLASS__, 'update', json_encode($request->all()));

            Cms::destroyCache([$this->slug]);
        }
        catch(Exception $e) {
            return $this->rollback($e, $request, 'update');
        }

        return redirect()->route('cms.'.$this->slug.'.edit', ['id' => $id, 'fid' => $request->fid])
            ->with('alert-success', trans('cms.info.updated'));
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

            // get the pivot 
            $pivot = $this->templateable->where('id', $id)->first();

            // get the class
            $moduleClass = new $pivot->templateable_type;

            // get the ids of the page items
            $pageIds = $moduleClass
                ->select('id')
                ->where('template_sibling', $pivot->templateable_id)
                ->pluck('id')
                ->toArray();

            // delete the pivots
            $this->pageable->whereIn('pageable_id', $pageIds)->delete();

            // delete the resource and its children
            $builder = $moduleClass
                ->where('template_sibling', $pivot->templateable_id)
                ->orWhere('id', $pivot->templateable_id)
                ->delete();

            // delete the pivots
            $this->templateable->where('id', $id)->delete();

            DB::commit();

            DbLog::add(__CLASS__, 'destroy', $id);

            Cms::destroyCache([$this->slug]);

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

                $this->templateable->timestamps = false;
                $this->templateable->where('id', $id)->update([
                    'drag_order' => $order,
                ]);

                // get the record so we can update the siblings
                $templateable = $this->templateable->where('id', $id)->first();

                // get the namespace
                $namespace = $templateable->templateable_type;

                // get the builder
                $builderInstance = new $namespace;

                // get the sibling builders, aka page builders
                $buildersIds = $builderInstance->where('template_sibling', $templateable->templateable_id)->pluck('id')->toArray();

                // update pageables
                $this->pageable->timestamps = false;
                $this->pageable->whereIn('pageable_id', $buildersIds)
                    ->where('pageable_type', $namespace)
                    ->update([
                        'drag_order' => $order,
                    ]);
            }

            DbLog::add(__CLASS__, 'order', json_encode($request->all()));

            DB::commit();

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

            if(env('APP_DEBUG') === true) {
                return response()->json([
                    'error' => $e->getMessage(),
                ], 500);
            }

            return response()->json([
                'error' => 'There was an error',
            ], 500);
        }
    }

}
