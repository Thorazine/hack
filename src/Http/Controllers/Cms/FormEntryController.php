<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Http\Requests\ModuleStore;
use Illuminate\Http\Request;
use Thorazine\Hack\Models\FormValue;
use Thorazine\Hack\Models\FormField;
use Thorazine\Hack\Models\FormEntry;
use Cms;
use DB;

class FormEntryController extends CmsController
{


    public function __construct(FormEntry $model, FormField $formField, FormValue $formValue)
    {
        $this->model = $model;
        $this->formField = $formField;
        $this->formValue = $formValue;
        $this->slug = 'form_fields';

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
        $formfields = $this->formField
            ->where('form_id', $request->fid)
            ->orderBy('drag_order')
            ->pluck('id')
            ->toArray();

        $datas = $this->formValue;

        if($formfields) {
            $orderIds = "'" . implode("','", $formfields) . "'";
            
            $datas = $datas->orderBy(DB::raw('FIELD(form_field_id, '.$orderIds.')'));                
        }

        $datas = $datas->paginate(count($formfields) * 50);

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

        return view('cms.form-field.index')
            ->with('datas', $datas)
            ->with('fid', $request->fid)
            ->with('searchFields', $this->searchFields);
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
        return $query->with('formValues');
    }
}
