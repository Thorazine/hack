<?php

namespace Thorazine\Hack\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Thorazine\Hack\Models\FormValidation;
use Thorazine\Hack\Models\Form;
use Request;
use Hack;

class FormBuilderStore extends FormRequest
{
    public $attributesArray = [];

    private $rules = [];

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
        $form = Form::find(Request::get('id'))
            ->with('formFields')
            ->first();

        $rules = [];

        foreach($form->formFields as $formField) {
            $rules[$formField['key']] = ($formField['regex']) ? $formField['regex'] : '';
            $this->attributesArray[$formField['key']] = ($formField['label']) ? $formField['label'] : '';
        }

        $this->rules = $rules;

        return $rules;
    }


    /*
     * Set the attributes
     */
    public function attributes()
    {
        return $this->attributesArray;
    }


    /*
     *  Get and set the custom error messages
     */
    public function messages()
    {
        $individualRules = [];

        foreach($this->rules as $rules) {
            $individualRules = array_merge($individualRules, explode('|', $rules));
        }


        $messages = FormValidation::whereIn('regex', $individualRules)
            ->where('language', Hack::site('language'))
            ->pluck('error_message', 'regex')
            ->toArray();

        return $messages;
    }
}
