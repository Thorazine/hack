<?php

namespace Thorazine\Hack\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Request;
use Session;
use App;

class BuilderUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // get the controller namespace
        list($namespace, $function) = explode('@', $this->route()->getAction()['controller']);

        // get controller instance
        $controller = App::make($namespace);

        // get the model
        $model = $controller->model;

        $module = $controller->templateable->where('id', Request::get('id'))->firstOrFail();

        $types = App::make($module->templateable_type)->types;

        $validations = [];
        foreach($types as $key => $type) {
            if(array_key_exists('regex', $type) && strpos($type['type'], 'label') === false) {

                if(is_array($type['regex']) && array_key_exists('edit', $type['regex'])) {
                    $validations[$key] = $type['regex']['edit'];
                }
                elseif(! is_array($type['regex'])) {
                    $validations[$key] = $type['regex'];
                }
            }
        }

        return $validations;
    }


    protected function failedValidation(Validator $validator)
    {
        Session::flash('alert-danger', trans('cms.error.validation'));
        parent::failedValidation($validator);
    }
}
