<?php

namespace App\Http\Requests\Skill;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSkillRequest extends FormRequest
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
            'name' => 'required|max:255|unique:skills,name,' . $this->skillId,
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
            'name.required' => trans('skill.msg.name-required'),
            'name.max' => trans('skill.msg.name-max'),
            'name.unique' => trans('skill.msg.name-unique'),
        ];
    }
}
