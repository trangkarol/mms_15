<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,'.$this->userId,
            'avatar' => 'mimes:jpeg,jpg|max:10000',
            'birthday' => 'required',
            'password' => 'min:6|confirmed',
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
            'name.required' => trans('user.msg.name-required'),
            'email.required' => trans('user.msg.email-required'),
            'email.unique' => trans('user.msg.email-unique'),
            'birthday.required' => trans('user.msg.birthday-required'),
            'password.confirmed' => trans('user.msg.password-confirmed'),
            'password.min' => trans('user.msg.password-min'),
        ];
    }
}
