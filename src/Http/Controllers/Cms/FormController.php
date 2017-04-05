<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Http\Requests\ModuleStore;
use Illuminate\Http\Request;
use Thorazine\Hack\Models\Form;
use Thorazine\Hack\Models\FormEntry;
use Thorazine\Hack\Models\FormField;
use Excel;
use Cms;

class FormController extends CmsController
{


    public function __construct(Form $model, FormEntry $formEntry, FormField $formField)
    {
        $this->model = $model;
        $this->formEntry = $formEntry;
        $this->formField = $formField;
        $this->slug = 'forms';

        view()->share([
            'extraItemButtons' => function($data) {
                return [
                    [
                        'class' => 'success',
                        'route' => route('cms.forms.download', ['id' => $data->id]),
                        'text' => '<i class="fa fa-download" aria-hidden="true"></i>',
                        'title' => trans('modules.forms.download'),
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
    public function download(Request $request, $id)
    {
        ini_set('memory_limit','500M');

        // get the form
        $form = $this->model->find($id);

        // get the id's from the paginate
        $formEntries = $this->formEntry
            ->where('form_id', $id)
            ->orderBy('id', 'asc')
            ->with('formValues')
            ->get();

        $formFields = $this->formField
            ->where('form_id', $id) 
            ->groupBy('key')
            ->orderBy('drag_order', 'asc')
            ->get();

        $array = [];
        foreach($formEntries as $index => $formEntry) {

            foreach($formFields as $formField) {
                $found = false;
                foreach($formEntry->formValues as $formValue) {
                    if($formValue->form_field_id == $formField->id) {
                        $array[$index][$formField->key] = $formValue->value;
                        $found = true;
                    }
                }

                if(! $found) {
                    $array[$index][$formField->key] = $formValue->value;
                }
            }

            $array[$index]['created_at'] = $formEntry->created_at;
        }

        Excel::create('Filename', function($excel) use ($array, $form) {
            // Set the title
            $excel->setTitle($form->title);

            $excel->setFilename(str_slug(Cms::site('title').'-'.$form->title.'-'.date('Ymd-His')));

            // Chain the setters
            if(trim(Cms::user('first_name').' '.Cms::user('last_name'))) {
                $excel->setCreator(trim(Cms::user('first_name').' '.Cms::user('last_name')));
            }
            else {
                $excel->setCreator(Cms::site('title').' CMS');
            }

            $excel->setCompany(Cms::site('title').' CMS');

            $excel->sheet('Sheet 1', function($sheet) use ($array) {
                $sheet->fromArray($array);
            });
        })->download($form->download_as);
    }
}
