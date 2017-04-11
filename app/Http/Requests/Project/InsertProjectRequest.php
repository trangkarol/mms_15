<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class InsertProjectRequest extends FormRequest
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
            'name' => 'required|max:255|unique:projects',
            'short_name' => 'required|max:255|unique:projects',
            'start_day' => 'required',
            'end_day' => 'required|after:start_day',
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
            'name.required' => trans('project.msg.name-required'),
            'name.unique' => trans('project.msg.name-unique'),
            'name.max' => trans('project.msg.name-max'),
            'short_name.required' => trans('project.msg.short_name-required'),
            'short_name.unique' => trans('project.msg.short_name-unique'),
            'short_name.max' => trans('project.msg.short_name-max'),
            'start_day.required' => trans('project.msg.start_day-required'),
            'end_day.required' => trans('project.msg.end_day-required'),
            'end_day.after' => trans('project.msg.end_day-after'),
        ];
    }
}
