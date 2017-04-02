<?php

namespace Thorazine\Hack\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Session;
use App;

class ModuleStore extends FormRequest
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

        $validations = [];
        foreach($model->types as $key => $type) {
            if(array_key_exists('regex', $type) && strpos($type['type'], 'label') === false) {

                if(is_array($type['regex']) && array_key_exists('create', $type['regex'])) {
                    $validations[$key] = $type['regex']['create'];
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
