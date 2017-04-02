<?php

namespace Thorazine\Hack\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Thorazine\Hack\Models\FormEntry;
use Request;

class FormBuilderUpdate extends FormRequest
{
    public $attributesArray = [];

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
        $form = FormEntry::find(Request::get('id'))
            ->with('formFields')
            ->first();

        $rules = [];

        foreach($form->formFields as $formField) {
            $rules[$formField['key']] = ($formField['regex']) ? $formField['regex'] : '';
            $this->attributesArray[$formField['key']] = ($formField['label']) ? $formField['label'] : '';
        }

        return $rules;
    }


    public function attributes()
    {
        return $this->attributesArray;
    }
}
