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
            'extraHeaderButtons' => function($data) {
                return [
                    [
                        'class' => 'primary',
                        'route' => route('cms.forms.index'),
                        'text' => '<i class="fa fa-arrow-left"></i> '. trans('cms.back'),
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
                'dataset' => view('cms.models.ajax.index')
                    ->with('datas', $datas)
                    ->with('fid', $request->fid)
                    ->with('searchFields', $this->searchFields)
                    ->render(),
                'paginate' => view('cms.models.ajax.paginate')
                    ->with('datas', $datas)
                    ->with('fid', $request->fid)
                    ->with('searchFields', $this->searchFields)
                    ->render(),
            ]);
        }

        return view('cms.models.index')
            ->with('datas', $datas)
            ->with('fid', $request->fid)
            ->with('searchFields', $this->searchFields);
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
