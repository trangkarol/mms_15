<?php

namespace App\Http\Requests\Position;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePositionRequest extends FormRequest
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
            'name' => 'required|max:255|unique:positions,name,'.$this->positionId,
            'short_name' => 'required|max:255|unique:positions,short_name,'.$this->positionId,
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
            'name.unique' => trans('position.msg.name-unique'),
            'name.max' => trans('position.msg.name-max'),
            'short_name.required' => trans('position.msg.short-name-required'),
            'short_name.unique' => trans('position.msg.short-name-unique'),
            'short_name.max' => trans('position.msg.short-name-max'),
        ];
    }
}
