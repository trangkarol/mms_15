<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class SearchProjectRequest extends FormRequest
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
            'startDay' => 'required',
            'endDay' => 'required|after:startDay',
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
            'startDay.required' => trans('project.msg.start_day-required'),
            'endDay.required' => trans('project.msg.end_day-required'),
            'endDay.after' => trans('project.msg.end_day-after'),
        ];
    }
}
