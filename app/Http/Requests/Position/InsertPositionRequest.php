<?php

namespace App\Http\Requests\Position;

use Illuminate\Foundation\Http\FormRequest;

class InsertPositionRequest extends FormRequest
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
            'name' => 'required',
            'short_name' => 'required',
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
            'name.required' => trans('position.msg.name-required'),
            'short_name.required' => trans('position.msg.short-name-required'),
        ];
    }
}
