<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Http\Requests\FormBuilderUpdate;
use Thorazine\Hack\Traits\ModuleHelper;
use Thorazine\Hack\Traits\ModuleSearch;
use App\Http\Controllers\Controller;
use Thorazine\Hack\Models\FormValue;
use Thorazine\Hack\Models\FormField;
use Thorazine\Hack\Models\FormEntry;
use Thorazine\Hack\Http\Requests;
use Thorazine\Hack\Models\DbLog;
use Illuminate\Http\Request;
use Exception;
use Cms;
use Log;
use DB;

class FormEntryController extends Controller
{

    use ModuleHelper;
    use ModuleSearch;

    public function __construct(FormEntry $model, FormField $formField, FormValue $formValue)
    {
        $this->model = $model;
        $this->formField = $formField;
        $this->formValue = $formValue;
        $this->slug = 'form_entries';

        view()->share([
            'slug' => $this->slug,
            'model' => $this->model,
            'hasOrder' => true,
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
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // get the id's from the paginate
        $formEntries = $this->model
            ->where('form_id', $request->fid)
            ->orderBy('id', 'asc')
            ->with('formValues')
            ->paginate(50);

        $formFields = $this->formField
            ->distinct('key')
            ->where('form_id', $request->fid)
            ->orderBy('drag_order', 'asc')
            ->get();

        return view('hack::form-entry.index')
            ->with('datas', $formEntries)
            ->with('formFields', $formFields)
            ->with('fid', $request->fid)
            ->with('searchFields', $this->searchFields);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {        
        // get the id's from the paginate
        $formEntry = $this->model
            ->where('id', $id)
            ->orderBy('id', 'asc')
            ->with('formValues')
            ->first();

        $formFields = $this->formField
            ->distinct('key')
            ->where('form_id', $formEntry->form_id)   
            ->orderBy('drag_order', 'asc')
            ->get();

        return view('hack::form-entry.edit')
            ->with('data', $formEntry)
            ->with('formFields', $formFields)
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
    public function update(FormBuilderUpdate $request, $id)
    {
        // Start insert
        try {
            DB::beginTransaction();

            // Callback
            $namespace = 'App\Models\Classes\FormEntryCallback';
            if(class_exists($namespace)) {
                
                $class = new $namespace();

                if(method_exists($class, 'update')) {
                    $class->update($this->model, $request, $id);
                }
            }

            // get the id's from the paginate
            $formEntry = $this->model
                ->where('id', $id)
                ->orderBy('id', 'asc')
                ->with('formValues')
                ->first();

            $formFields = $this->formField
                ->distinct('key')
                ->where('form_id', $formEntry->form_id) 
                ->orderBy('drag_order', 'asc')
                ->get();

            foreach($formFields as $formField) {
                $found = false;
                foreach($formEntry->formValues as $formValue) {
                    if($formValue->form_field_id == $formField->id) {
                        $this->formValue->where('id', $formValue->id)->update([
                            'value' => $request->{$formField->key},
                        ]);
                        $found = true;
                    }
                }

                if(! $found) {
                    // Could not find form value. So we need to create it
                    $this->formValue->insert([
                        'form_entry_id' => $id,
                        'form_field_id' => $formField->id,
                        'form_id' => $formEntry->form_id,
                        'value' => $request->{$formField->key},
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }

            DbLog::add(__CLASS__, 'update', json_encode($request->all()));

            DB::commit();

            Cms::destroyCache([$this->slug, 'forms', 'form_values', 'form_fields']);
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

            // Callback
            $namespace = 'App\Models\Classes\FormEntryCallback';
            if(class_exists($namespace)) {
                
                $class = new $namespace();

                if(method_exists($class, 'destroy')) {
                    $class->destroy($this->model, $id);
                }
            }

            // delete children
            $this->formValue->where('form_entry_id', $id)->delete();

            // delete parent
            $this->model->where('id', $id)->delete();

            DbLog::add(__CLASS__, 'delete', $id);

            DB::commit();

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
