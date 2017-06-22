<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Thorazine\Hack\Http\Requests\ModuleUpdate;
use Thorazine\Hack\Http\Requests\ModuleStore;
use Thorazine\Hack\Traits\ModuleHelper;
use Illuminate\Http\Request;
use Thorazine\Hack\Models\Template;
use Thorazine\Hack\Http\Requests;
use Thorazine\Hack\Models\DbLog;
use Thorazine\Hack\Models\Page;
use Exception;
use Cms;
use Log;
use DB;

class TemplateController extends CmsController
{
    
    public function __construct(Template $model, Page $page)
    {
        $this->model = $model;
        $this->page = $page;
        $this->slug = 'templates';

        parent::__construct($this);

        view()->share([
            'extraItemButtons' => function($data) {
                return [
                    [
                        'class' => 'primary',
                        'route' => route('cms.builder.index', (($data->id) ? ['fid' => $data->id] : [] )),
                        'text' => 'Builder',
                    ],
                ];
            },
            'extraEditButtons' => function($data) {
                return [
                    [
                        'class' => '',
                        'route' => route('cms.builder.index', ['fid' => $data['id']]),
                        'text' => '<i class="fa fa-cubes"></i> Add builder',
                    ]
                ];
            }
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

        $datas = $this->search($this->queryParameters($this->model, $request), $request)
            ->with('pages')
            ->paginate();

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

        return view('hack::models.create')
            ->with('data', $data);
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

            $id = $this->model->insertGetId($this->prepareValues($request, false, ['site_id' => Cms::siteId()]));

            DB::commit();

            DbLog::add(__CLASS__, 'store', json_encode($request->all()));

            Cms::destroyCache([$this->slug]);
        }
        catch(Exception $e) {
            return $this->rollback($e, $request);
        }

        return redirect()->route('cms.'.$this->slug.'.edit', $id)
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

        return view('hack::models.edit')
            ->with('data', $data)
            ->with('id', $id);
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

            $this->model->where('id', $id)->update($this->prepareValues($request, $id));

            $this->page->where('template_id', $id)->update($this->prepareValues([
                'prepend_slug' => $request->prepend_slug,
                'view' => $request->view,
            ], $id));

            DB::commit();

            DbLog::add(__CLASS__, 'update', json_encode($request->all()));

            Cms::destroyCache([$this->slug]);
        }
        catch(Exception $e) {
            return $this->rollback($e, $request, 'update');
        }

        return redirect()->route('cms.'.$this->slug.'.edit', $id)
            ->with('alert-success', trans('cms.info.updated'));
    }



    /**
     * Possibly add query parameters to the model
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function queryParameters($query, $request)
    {
        return $query;
    }
}
