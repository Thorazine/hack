<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Http\Requests\ModuleStore;
use Illuminate\Http\Request;
use Thorazine\Hack\Models\FormField;
use Cms;

class FormFieldController extends CmsController
{


    public function __construct(FormField $model)
    {
        $this->model = $model;
        $this->slug = 'form_fields';
        $this->hasOrder = true;

        view()->share([
            'hasOrder' => true,
            'createRoute' => 'cms.form_fields.module',
            'extraHeaderButtons' => function($data) {
                return [
                    [
                        'class' => 'primary',
                        'route' => route('cms.forms.index'),
                        'text' => '<i class="fa fa-arrow-left"></i> '. trans('hack::cms.back'),
                    ],
                ];
            },
        ]);

        parent::__construct($this);
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
            ->orderBy('drag_order')
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function module(Request $request)
    {
        $this->viewInitialiser();
         
        return view('hack::form-field.module');
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
            $data = [
                'field_type' => $request->field_type,
            ];
        }

        $this->model->types['values']['type'] = config('cms.forms.types.'.$data['field_type'].'.type');

        view()->share([
            'types' => $this->model->types,
        ]);

        return view('hack::form-field.create')
            ->with('data', $data);
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
        $this->extraCreateValues = [
            'form_id' => $request->fid,
        ];
        
        return $request;
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

        $this->model->types['values']['type'] = config('cms.forms.types.'.$data['field_type'].'.type');

        view()->share([
            'types' => $this->model->types,
        ]);

        return $this->child->editExtra($request, $id, $data);
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
        if($request->fid) {
            return $query->where('form_id', $request->fid);
        }
        return $query;
    }
}
