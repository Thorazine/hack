<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Http\Requests\ModuleStore;
use Illuminate\Http\Request;
use Thorazine\Hack\Models\Form;
use Cms;

class FormController extends CmsController
{


    public function __construct(Form $model)
    {
        $this->model = $model;
        $this->slug = 'forms';

        view()->share([
            'extraItemButtons' => function($data) {
                return [
                    [
                        'class' => 'success',
                        'route' => route('cms.forms.download', ['id' => $data->id]),
                        'text' => '<i class="fa fa-download" aria-hidden="true"></i>',
                    ],
                    [
                        'class' => 'primary',
                        'route' => route('cms.form_entries.index', (($data->id) ? ['fid' => $data->id] : [] )),
                        'text' => trans('modules.forms.entries'),
                    ],
                    [
                        'class' => 'primary',
                        'route' => route('cms.form_fields.index', (($data->id) ? ['fid' => $data->id] : [] )),
                        'text' => trans('modules.forms.fields'),
                    ],
                ];
            },
        ]);

        parent::__construct($this);
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
            'site_id' => Cms::siteId(),
        ];

        return $request;
    }


    public function show(Request $request)
    {

        $datas = $this->model
            ->with('formFields')
            ->paginate(100);

        return view('cms.form.show')
            ->with('datas', $datas);
    }


    /**
     * Download all the form entries 
     */
    public function download()
    {
        
    }
}
