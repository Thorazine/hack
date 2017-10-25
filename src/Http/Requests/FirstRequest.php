<?php

namespace Thorazine\Hack\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FirstRequest extends FormRequest
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
        return [
            'email' => 'required|email',
            'password' => 'required|min:6|max:50|confirmed',
            'title' => '',
            'language' => 'required',
            'protocol' => 'required|in:http://,https://',
            'domain' => 'required',
        ];
    }
}
