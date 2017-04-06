<?php

namespace App\Http\Requests\Team;

use Illuminate\Foundation\Http\FormRequest;

class InsertRequest extends FormRequest
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
            'name' => 'required|unique:teams|max:255',
            'description' => 'required',
        ];
    }

    /**
     * messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => trans('team.msg.name-required'),
            'name.unique' => trans('team.msg.name-unique'),
            'name.max' => trans('team.msg.name-max'),
            'description.required' => trans('team.msg.description-required'),
        ];
    }
}
